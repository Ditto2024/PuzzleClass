<?php

namespace App\Providers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        User::created(function ($user) {
            Profile::create([
                'user_id' => $user->id,
                'level' => 1,
                'xp' => 0,
                'coins' => 100,
                'points' => 0,
                'hints' => 3,
            ]);
        });
    }
}