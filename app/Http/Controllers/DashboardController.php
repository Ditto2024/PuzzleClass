<?php

namespace App\Http\Controllers;

use App\Models\Quest;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('profile');

        $quests = Quest::with('puzzles')
            ->where('is_active', true)
            ->orderBy('order')
            ->take(3)
            ->get();

        $profile = $user->profile;

        $currentXp = $profile->xp ?? 0;
        $level = $profile->level ?? 1;
        $xpTarget = $level * 200;
        $xpPercent = $xpTarget > 0 ? min(100, ($currentXp / $xpTarget) * 100) : 0;

        $canClaimDailyReward = ! $profile->last_daily_reward_claimed_at
            || ! $profile->last_daily_reward_claimed_at->isToday();

        return view('dashboard', compact(
            'user',
            'quests',
            'profile',
            'currentXp',
            'level',
            'xpTarget',
            'xpPercent',
            'canClaimDailyReward'
        ));
    }

    public function claimDailyReward()
    {
        $user = auth()->user()->load('profile');
        $profile = $user->profile;

        if (! $profile) {
            return back()->with('error', 'Profile user belum ditemukan.');
        }

        if ($profile->last_daily_reward_claimed_at && $profile->last_daily_reward_claimed_at->isToday()) {
            return back()->with('error', 'Daily reward hari ini sudah diambil.');
        }

        if ($profile->last_daily_reward_claimed_at && $profile->last_daily_reward_claimed_at->isYesterday()) {
            $profile->streak_count += 1;
        } else {
            $profile->streak_count = 1;
        }

        $profile->coins += 50;
        $profile->last_daily_reward_claimed_at = now();
        $profile->save();

        return redirect()->route('dashboard')->with('success', 'Daily reward +50 coins berhasil di-claim.');
    }
}