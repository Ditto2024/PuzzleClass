<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('profile');

        return view('settings.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user()->load('profile');
        $profile = $user->profile;

        $profile->sound_enabled = $request->boolean('sound_enabled');
        $profile->dark_mode = $request->boolean('dark_mode');
        $profile->auto_next_enabled = $request->boolean('auto_next_enabled');
        $profile->save();

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}