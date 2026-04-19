<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPuzzleAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'puzzle_id',
        'submitted_answer',
        'used_hint',
        'is_correct',
        'earned_points',
        'combo_count',
    ];

    protected $casts = [
        'used_hint' => 'boolean',
        'is_correct' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function puzzle()
    {
        return $this->belongsTo(Puzzle::class);
    }
}