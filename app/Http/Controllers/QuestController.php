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

        $solvedPuzzleIds = UserPuzzleAttempt::where('user_id', $user->id)
            ->where('is_correct', true)
            ->pluck('puzzle_id')
            ->toArray();

        $puzzles = $quest->puzzles->sortBy('order')->values();

        $currentPuzzle = $puzzles->first(fn ($item) => ! in_array($item->id, $solvedPuzzleIds));
        $questCompleted = false;

        if (! $currentPuzzle) {
            $questCompleted = true;
            $currentPuzzle = $puzzles->first();
        }

        $lastCorrectAttempt = UserPuzzleAttempt::where('user_id', $user->id)
            ->where('is_correct', true)
            ->latest()
            ->first();

        $comboCount = $lastCorrectAttempt?->combo_count ?? 0;

        $timeLeft = $currentPuzzle
            ? ($currentPuzzle->time_limit + ($user->profile->time_bonus_seconds ?? 0))
            : 0;

        $answerOptions = $this->buildAnswerOptions($currentPuzzle);

        return view('quests.show', [
            'quest' => $quest,
            'puzzle' => $currentPuzzle,
            'questCompleted' => $questCompleted,
            'timeLeft' => $timeLeft,
            'comboCount' => max(1, $comboCount),
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
        $quest = $puzzle->quest;

        $submittedAnswer = strtolower(trim($request->answer));
        $correctAnswer = strtolower(trim($puzzle->answer));
        $isCorrect = $submittedAnswer === $correctAnswer;

        $alreadySolved = UserPuzzleAttempt::where('user_id', $user->id)
            ->where('puzzle_id', $puzzle->id)
            ->where('is_correct', true)
            ->exists();

        $lastCorrectAttempt = UserPuzzleAttempt::where('user_id', $user->id)
            ->where('is_correct', true)
            ->latest()
            ->first();

        $comboCount = $isCorrect
            ? (($lastCorrectAttempt?->combo_count ?? 0) + 1)
            : 0;

        $earnedPoints = $isCorrect && ! $alreadySolved
            ? $puzzle->bonus_points + max(0, ($comboCount - 1) * 10)
            : 0;

        UserPuzzleAttempt::create([
            'user_id' => $user->id,
            'puzzle_id' => $puzzle->id,
            'submitted_answer' => $request->answer,
            'used_hint' => false,
            'is_correct' => $isCorrect,
            'earned_points' => $earnedPoints,
            'combo_count' => $comboCount,
        ]);

        if (! $isCorrect) {
            $profile->last_puzzle_played_at = now();
            $profile->save();

            return back()->with('error', 'Jawaban masih salah, coba lagi.');
        }

        if (! $alreadySolved) {
            $profile->points += $earnedPoints;
            $profile->xp += 50;
            $profile->coins += 20;
            $profile->puzzles_solved += 1;
            $profile->last_puzzle_played_at = now();

            if ($profile->time_bonus_seconds > 0) {
                $profile->time_bonus_seconds = 0;
            }

            while ($profile->xp >= ($profile->level * 200)) {
                $profile->xp -= ($profile->level * 200);
                $profile->level += 1;
            }

            $questPuzzleIds = $quest->puzzles()->pluck('id')->toArray();

            $solvedQuestCount = UserPuzzleAttempt::where('user_id', $user->id)
                ->whereIn('puzzle_id', $questPuzzleIds)
                ->where('is_correct', true)
                ->distinct('puzzle_id')
                ->count('puzzle_id');

            if ($solvedQuestCount === count($questPuzzleIds)) {
                $profile->points += $quest->reward_points;
                $profile->xp += $quest->reward_xp;
            }

            $profile->save();
        }

        return redirect()
            ->route('quests.show', $quest)
            ->with('success', $quest->puzzles()->count() > 1 ? 'Benar! Lanjut ke puzzle berikutnya.' : 'Benar! Quest selesai.');
    }

    private function buildAnswerOptions(?Puzzle $puzzle): array
    {
        if (! $puzzle) {
            return [];
        }

        return match ($puzzle->answer) {
            '4' => ['3', '4', '5'],
            'xor' => ['and', 'xor', 'or'],
            'alpha-7' => ['alpha-5', 'alpha-7', 'alpha-9'],
            default => [
                $puzzle->answer,
                $puzzle->answer . 'x',
                strrev($puzzle->answer),
            ],
        };
    }
}