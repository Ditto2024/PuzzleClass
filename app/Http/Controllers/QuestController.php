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
        $today = now()->toDateString();

        foreach ($quests as $quest) {
            $questPuzzleIds = $quest->puzzles->pluck('id')->toArray();

            $solvedCount = UserPuzzleAttempt::where('user_id', $user->id)
                ->whereIn('puzzle_id', $questPuzzleIds)
                ->where('is_correct', true)
                ->whereDate('created_at', $today)
                ->distinct('puzzle_id')
                ->count('puzzle_id');

            $questTotal = count($questPuzzleIds);

            $previousQuest = $quests->firstWhere('order', $quest->order - 1);
            $previousDone = true;

            if ($previousQuest) {
                $prevPuzzleIds = $previousQuest->puzzles->pluck('id')->toArray();

                $prevCorrectCount = UserPuzzleAttempt::where('user_id', $user->id)
                    ->whereIn('puzzle_id', $prevPuzzleIds)
                    ->where('is_correct', true)
                    ->whereDate('created_at', $today)
                    ->distinct('puzzle_id')
                    ->count('puzzle_id');

                $previousDone = $prevCorrectCount === count($prevPuzzleIds);
            }

            if ($questTotal > 0 && $solvedCount === $questTotal) {
                $quest->ui_status = 'Done';
                $quest->progress_percent = 100;
            } elseif ($previousDone) {
                $quest->ui_status = 'Start';
                $quest->progress_percent = $questTotal > 0 ? intval(($solvedCount / $questTotal) * 100) : 0;
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

        $today = now()->toDateString();
        $currentOrder = (int) request('step', 1);
        $puzzles = $quest->puzzles->sortBy('order')->values();

        $answeredTodayPuzzleIds = UserPuzzleAttempt::where('user_id', $user->id)
            ->whereIn('puzzle_id', $puzzles->pluck('id'))
            ->whereDate('created_at', $today)
            ->pluck('puzzle_id')
            ->unique()
            ->toArray();

        if (request()->has('step')) {
            $currentPuzzle = $puzzles->firstWhere('order', $currentOrder);
        } else {
            $currentPuzzle = $puzzles->first(fn ($p) => ! in_array($p->id, $answeredTodayPuzzleIds)) ?? $puzzles->first();
        }

        $questCompleted = count($answeredTodayPuzzleIds) >= $puzzles->count();

        if ($questCompleted) {
            $currentPuzzle = $puzzles->last();
        }

        $lastAttempt = UserPuzzleAttempt::where('user_id', $user->id)->latest()->first();

        $comboCount = $lastAttempt && $lastAttempt->is_correct
            ? max(1, $lastAttempt->combo_count)
            : 1;

        $timeLeft = $currentPuzzle
            ? $currentPuzzle->time_limit
            : 0;

        $answerOptions = $this->buildAnswerOptions($currentPuzzle);

        $currentStep = $currentPuzzle?->order ?? 1;
        $totalSteps = $puzzles->count();

        return view('quests.show', [
            'quest' => $quest,
            'puzzle' => $currentPuzzle,
            'questCompleted' => $questCompleted,
            'timeLeft' => $timeLeft,
            'comboCount' => $comboCount,
            'answerOptions' => $answerOptions,
            'currentStep' => $currentStep,
            'totalSteps' => $totalSteps,
        ]);
    }

    public function complete(Quest $quest)
    {
        return view('quests.complete', compact('quest'));
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

    public function useTimeBoost(Puzzle $puzzle)
    {
        $user = auth()->user()->load('profile');
        $profile = $user->profile;

        if (($profile->time_boost_15 ?? 0) <= 0) {
            return back()->with('error', 'Item +15 detik belum tersedia. Beli dulu di shop.');
        }

        $profile->time_boost_15 -= 1;
        $profile->save();

        return back()->with('time_boost_used', 15);
    }

    public function answer(Request $request, Puzzle $puzzle)
    {
        $request->validate([
            'answer' => ['required', 'string'],
        ]);

        return $this->processAnswer($puzzle, $request->answer, false);
    }

    public function timeout(Puzzle $puzzle)
    {
        return $this->processAnswer($puzzle, 'TIMEOUT', true);
    }

    private function processAnswer(Puzzle $puzzle, string $answer, bool $isTimeout)
    {
        $user = auth()->user()->load('profile');
        $profile = $user->profile;
        $quest = $puzzle->quest->load('puzzles');
        $today = now()->toDateString();

        $submittedAnswer = strtolower(trim($answer));
        $correctAnswer = strtolower(trim($puzzle->answer));
        $isCorrect = ! $isTimeout && $submittedAnswer === $correctAnswer;

        $lastAttempt = UserPuzzleAttempt::where('user_id', $user->id)->latest()->first();

        $comboCount = $isCorrect
            ? (($lastAttempt && $lastAttempt->is_correct) ? $lastAttempt->combo_count + 1 : 1)
            : 0;

        $alreadyAnsweredToday = UserPuzzleAttempt::where('user_id', $user->id)
            ->where('puzzle_id', $puzzle->id)
            ->whereDate('created_at', $today)
            ->exists();

        if (! $alreadyAnsweredToday) {
            UserPuzzleAttempt::create([
                'user_id' => $user->id,
                'puzzle_id' => $puzzle->id,
                'submitted_answer' => $isTimeout ? 'WAKTU HABIS' : $answer,
                'used_hint' => false,
                'is_correct' => $isCorrect,
                'earned_points' => $isCorrect ? $puzzle->bonus_points : 0,
                'combo_count' => $comboCount,
            ]);

            if ($isCorrect) {
                $profile->points += $puzzle->bonus_points;
                $profile->xp += 10;
                $profile->coins += 5;
                $profile->puzzles_solved += 1;
            }

            $profile->last_puzzle_played_at = now();

            while ($profile->xp >= ($profile->level * 200)) {
                $profile->xp -= ($profile->level * 200);
                $profile->level += 1;
            }

            $profile->save();
        }

        $nextPuzzle = $quest->puzzles
            ->sortBy('order')
            ->first(fn ($item) => $item->order > $puzzle->order);

        if ($nextPuzzle) {
            $message = $isTimeout
                ? 'Waktu habis ⏱️ lanjut ke soal berikutnya.'
                : ($isCorrect ? 'Benar! 🔥 Lanjut...' : 'Salah 😅 lanjut dulu!');

            return redirect()
                ->route('quests.show', ['quest' => $quest->id, 'step' => $nextPuzzle->order])
                ->with($isCorrect ? 'success' : 'error', $message)
                ->with('answer_state', $isCorrect ? 'correct' : 'wrong');
        }

        return $this->finishQuest($quest);
    }

    private function finishQuest(Quest $quest)
    {
        $user = auth()->user()->load('profile');
        $profile = $user->profile;
        $today = now()->toDateString();

        $quest->load('puzzles');
        $questPuzzleIds = $quest->puzzles->pluck('id');

        $totalCorrect = UserPuzzleAttempt::where('user_id', $user->id)
            ->whereIn('puzzle_id', $questPuzzleIds)
            ->where('is_correct', true)
            ->whereDate('created_at', $today)
            ->distinct('puzzle_id')
            ->count('puzzle_id');

        $rewardAlreadyGiven = session('quest_reward_given_' . $quest->id . '_' . $today, false);

        $pointsReward = $quest->reward_points + ($totalCorrect * 10);
        $xpReward = $quest->reward_xp + ($totalCorrect * 5);
        $coinsReward = 50 + ($totalCorrect * 5);

        if (! $rewardAlreadyGiven) {
            $profile->points += $pointsReward;
            $profile->xp += $xpReward;
            $profile->coins += $coinsReward;

            while ($profile->xp >= ($profile->level * 200)) {
                $profile->xp -= ($profile->level * 200);
                $profile->level += 1;
            }

            $profile->save();

            session(['quest_reward_given_' . $quest->id . '_' . $today => true]);
        }

        return redirect()->route('quests.complete', $quest->id)
            ->with([
                'points' => $pointsReward,
                'xp' => $xpReward,
                'coins' => $coinsReward,
                'correct' => $totalCorrect,
            ]);
    }

    private function buildAnswerOptions(?Puzzle $puzzle): array
    {
        if (! $puzzle) {
            return [];
        }

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
            default => [$puzzle->answer, 'opsi1', 'opsi2'],
        };
    }
}