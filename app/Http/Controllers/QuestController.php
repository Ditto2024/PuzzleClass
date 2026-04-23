<?php

namespace App\Http\Controllers;

use App\Models\Puzzle;
use App\Models\Quest;
use App\Models\UserPuzzleAttempt;
use Illuminate\Http\Request;

class QuestController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $quests = Quest::with('puzzles')->where('is_active', true)->orderBy('order')->get();

        $solvedPuzzleIds = UserPuzzleAttempt::where('user_id', $user->id)
            ->where('is_correct', true)
            ->pluck('puzzle_id')
            ->toArray();

        $previousQuestDone = true;

        foreach ($quests as $quest) {
            $questPuzzleIds = $quest->puzzles->pluck('id')->toArray();
            $questTotal = count($questPuzzleIds);
            $solvedCount = count(array_intersect($questPuzzleIds, $solvedPuzzleIds));

            if ($questTotal > 0 && $solvedCount === $questTotal) {
                $quest->ui_status = 'Done';
                $quest->progress_percent = 100;
                $previousQuestDone = true;
            } elseif ($previousQuestDone) {
                $quest->ui_status = 'Start';
                $quest->progress_percent = $questTotal > 0 ? intval(($solvedCount / $questTotal) * 100) : 0;
                $previousQuestDone = false;
            } else {
                $quest->ui_status = 'Locked';
                $quest->progress_percent = 0;
            }
        }

        return view('quests.index', compact('quests'));
    }

    public function show(Quest $quest)
    {
        $user = auth()->user()->load('profile');
        $quest->load('puzzles');

        $currentOrder = request('step');

        $puzzles = $quest->puzzles->sortBy('order')->values();

        if ($currentOrder) {
            $currentPuzzle = $puzzles->firstWhere('order', (int) $currentOrder);
        } else {
            $currentPuzzle = $puzzles->first();
        }

        $questCompleted = false;

        if (! $currentPuzzle) {
            $questCompleted = true;
            $currentPuzzle = $puzzles->last();
        }

        $lastAttempt = UserPuzzleAttempt::where('user_id', $user->id)
            ->latest()
            ->first();

        $comboCount = $lastAttempt && $lastAttempt->is_correct
            ? max(1, $lastAttempt->combo_count)
            : 1;

        $timeLeft = $currentPuzzle
            ? ($currentPuzzle->time_limit + ($user->profile->time_bonus_seconds ?? 0))
            : 0;

        $answerOptions = $this->buildAnswerOptions($currentPuzzle);

        return view('quests.show', [
            'quest' => $quest,
            'puzzle' => $currentPuzzle,
            'questCompleted' => $questCompleted,
            'timeLeft' => $timeLeft,
            'comboCount' => $comboCount,
            'answerOptions' => $answerOptions,
        ]);
    }

    public function useHint(Puzzle $puzzle)
    {
        $user = auth()->user()->load('profile');
        $profile = $user->profile;

        if ($profile->hints > 0) {
            $profile->hints -= 1;
        } elseif ($profile->coins >= 20) {
            $profile->coins -= 20;
        } else {
            return back()->with('error', 'Hint tidak cukup. Butuh 1 hint atau 20 coins.');
        }

        $profile->save();

        return back()->with('hint_text', $puzzle->hint ?? 'Hint belum tersedia.');
    }

    public function answer(Request $request, Puzzle $puzzle)
    {
        $request->validate([
            'answer' => ['required', 'string'],
        ]);

        $user = auth()->user()->load('profile');
        $profile = $user->profile;
        $quest = $puzzle->quest->load('puzzles');

        $submittedAnswer = strtolower(trim($request->answer));
        $correctAnswer = strtolower(trim($puzzle->answer));
        $isCorrect = $submittedAnswer === $correctAnswer;

        $lastAttempt = UserPuzzleAttempt::where('user_id', $user->id)
            ->latest()
            ->first();

        $comboCount = $isCorrect
            ? (($lastAttempt && $lastAttempt->is_correct) ? $lastAttempt->combo_count + 1 : 1)
            : 0;

        $earnedPoints = $isCorrect ? $puzzle->bonus_points + max(0, ($comboCount - 1) * 10) : 0;

        UserPuzzleAttempt::create([
            'user_id' => $user->id,
            'puzzle_id' => $puzzle->id,
            'submitted_answer' => $request->answer,
            'used_hint' => false,
            'is_correct' => $isCorrect,
            'earned_points' => $earnedPoints,
            'combo_count' => $comboCount,
        ]);

        if ($isCorrect) {
            $profile->points += $earnedPoints;
            $profile->xp += 20;
            $profile->coins += 10;
            $profile->puzzles_solved += 1;

            while ($profile->xp >= ($profile->level * 200)) {
                $profile->xp -= ($profile->level * 200);
                $profile->level += 1;
            }
        }

        $profile->last_puzzle_played_at = now();

        if ($profile->time_bonus_seconds > 0) {
            $profile->time_bonus_seconds = 0;
        }

        $profile->save();

        $nextPuzzle = $quest->puzzles
            ->sortBy('order')
            ->first(fn ($item) => $item->order > $puzzle->order);

        if ($nextPuzzle) {
            return redirect()
                ->route('quests.show', ['quest' => $quest->id, 'step' => $nextPuzzle->order])
                ->with($isCorrect ? 'success' : 'error', $isCorrect ? 'Jawaban benar! Lanjut ke soal berikutnya.' : 'Jawaban salah. Tetap lanjut ke soal berikutnya.');
        }

        if ($isCorrect) {
            $profile->points += $quest->reward_points;
            $profile->xp += $quest->reward_xp;

            while ($profile->xp >= ($profile->level * 200)) {
                $profile->xp -= ($profile->level * 200);
                $profile->level += 1;
            }

            $profile->save();
        }

        return redirect()
            ->route('quests.show', ['quest' => $quest->id, 'step' => 999])
            ->with($isCorrect ? 'success' : 'error', $isCorrect ? 'Quest selesai!' : 'Quest selesai, tapi ada jawaban yang salah.');
    }

    private function buildAnswerOptions(?Puzzle $puzzle): array
    {
        if (! $puzzle) return [];

        return match ($puzzle->answer) {
            'langkah-langkah' => ['langkah-langkah', 'acak', 'gambar'],
            'terurut' => ['acak', 'terurut', 'random'],
            'menyelesaikan masalah' => ['main game', 'menyelesaikan masalah', 'menggambar'],
            'jelas' => ['jelas', 'rumit', 'acak'],
            'selesai' => ['mulai', 'selesai', 'ulang'],

            'true' => ['true', 'false', 'error'],
            'false' => ['true', 'false', 'loop'],
            'if' => ['if', 'loop', 'array'],
            'else' => ['if', 'else', 'for'],
            'benar' => ['benar', 'salah', 'loop'],

            'loop' => ['loop', 'if', 'array'],
            'for' => ['for', 'if', 'else'],
            'while' => ['while', 'for', 'if'],
            'sequence' => ['sequence', 'loop', 'branch'],
            '4' => ['3', '4', '5'],
            'xor' => ['and', 'xor', 'or'],
            'alpha-7' => ['alpha-5', 'alpha-7', 'alpha-9'],

            default => [$puzzle->answer, 'opsi1', 'opsi2'],
        };
    }
}