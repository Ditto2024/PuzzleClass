<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('profile');

        if (! $user->profile) {
            $user->profile()->create([
                'level' => 1,
                'xp' => 0,
                'coins' => 100,
                'points' => 0,
                'hints' => 3,
                'streak_count' => 0,
                'puzzles_solved' => 0,
                'time_bonus_seconds' => 0,
                'time_boost_15' => 0,
                'sound_enabled' => true,
                'dark_mode' => false,
                'reduce_animation' => false,
                'auto_next_enabled' => true,
            ]);

            $user->load('profile');
        }

        return view('settings.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user()->load('profile');

        if (! $user->profile) {
            $user->profile()->create([
                'level' => 1,
                'xp' => 0,
                'coins' => 100,
                'points' => 0,
                'hints' => 3,
                'streak_count' => 0,
                'puzzles_solved' => 0,
                'time_bonus_seconds' => 0,
            ]);

            $user->load('profile');
        }

        $profile = $user->profile;

        $profile->sound_enabled = $request->boolean('sound_enabled');
        $profile->dark_mode = $request->boolean('dark_mode');

        if (array_key_exists('reduce_animation', $profile->getAttributes())) {
            $profile->reduce_animation = $request->boolean('reduce_animation');
        }

        if (array_key_exists('auto_next_enabled', $profile->getAttributes())) {
            $profile->auto_next_enabled = $request->boolean('auto_next_enabled');
        }

        $profile->save();

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}