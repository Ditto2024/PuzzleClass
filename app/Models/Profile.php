<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'level',
        'xp',
        'coins',
        'points',
        'hints',
        'streak_count',
        'puzzles_solved',
        'time_bonus_seconds',
        'last_daily_reward_claimed_at',
        'last_puzzle_played_at',
        'avatar',
    ];

    protected $casts = [
        'last_daily_reward_claimed_at' => 'datetime',
        'last_puzzle_played_at' => 'datetime',
    ];

    protected $appends = [
        'avatar_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAvatarUrlAttribute(): ?string
    {
        if (! $this->avatar) {
            return null;
        }

        return Storage::disk('public')->url($this->avatar);
    }
}