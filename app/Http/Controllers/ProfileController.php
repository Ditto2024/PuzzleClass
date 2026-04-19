<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user()->load('profile');

        return view('profile.edit', compact('user'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user()->load('profile');

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

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

        if ($request->hasFile('avatar')) {
            if ($user->profile->avatar && Storage::disk('public')->exists($user->profile->avatar)) {
                Storage::disk('public')->delete($user->profile->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->profile->avatar = $path;
            $user->profile->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function showGameProfile()
    {
        $user = auth()->user()->load('profile');

        return view('profile.page', compact('user'));
    }
}