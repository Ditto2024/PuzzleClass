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
            ->sortByDesc(fn ($u) => optional($u->profile)->points ?? 0)
            ->values();

        $rank = $leaders->search(fn ($u) => $u->id === $user->id);
        $rank = $rank === false ? null : $rank + 1;

        return view('leaderboard.index', compact('leaders', 'user', 'rank'));
    }
}