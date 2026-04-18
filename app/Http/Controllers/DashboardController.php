<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('profile');

        $quests = Quest::where('is_active', true)
            ->orderBy('order')
            ->take(3)
            ->get();

        $currentXp = optional($user->profile)->xp ?? 0;
        $level = optional($user->profile)->level ?? 1;
        $xpTarget = $level * 200;
        $xpPercent = $xpTarget > 0 ? min(100, ($currentXp / $xpTarget) * 100) : 0;

        return view('dashboard', compact(
            'user',
            'quests',
            'currentXp',
            'level',
            'xpTarget',
            'xpPercent'
        ));
    }
}