<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}