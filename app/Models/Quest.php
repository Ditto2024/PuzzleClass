<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'reward_points',
        'reward_xp',
        'order',
        'is_active',
    ];

    public function puzzles()
    {
        return $this->hasMany(Puzzle::class);
    }
}