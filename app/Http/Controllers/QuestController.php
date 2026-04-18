<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\Puzzle;
use App\Models\UserPuzzleAttempt;
use Illuminate\Http\Request;

class QuestController extends Controller
{
    public function index()
    {
        $quests = Quest::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('quests.index', compact('quests'));
    }

    public function show(Quest $quest)
    {
        $puzzle = $quest->puzzles()->orderBy('order')->first();

        return view('quests.show', compact('quest', 'puzzle'));
    }

    public function answer(Request $request, Puzzle $puzzle)
    {
        $user = auth()->user();
        $answer = strtolower(trim($request->answer));

        $correct = $answer === strtolower($puzzle->answer);

        UserPuzzleAttempt::create([
            'user_id' => $user->id,
            'puzzle_id' => $puzzle->id,
            'submitted_answer' => $answer,
            'is_correct' => $correct,
            'earned_points' => $correct ? $puzzle->bonus_points : 0,
        ]);

        if ($correct) {
            $profile = $user->profile;
            $profile->points += $puzzle->bonus_points;
            $profile->xp += 10;
            $profile->save();
        }

        return back()->with('result', $correct ? 'Benar!' : 'Salah!');
    }
}