<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('profile');

        $leaders = User::with('profile')
            ->get()
            ->sort(function ($a, $b) {
                $pointsA = optional($a->profile)->points ?? 0;
                $pointsB = optional($b->profile)->points ?? 0;

                if ($pointsA === $pointsB) {
                    return (optional($b->profile)->xp ?? 0) <=> (optional($a->profile)->xp ?? 0);
                }

                return $pointsB <=> $pointsA;
            })
            ->values();

        $rank = $leaders->search(fn ($u) => $u->id === $user->id);
        $rank = $rank === false ? null : $rank + 1;

        return view('leaderboard.index', compact('leaders', 'user', 'rank'));
    }
}