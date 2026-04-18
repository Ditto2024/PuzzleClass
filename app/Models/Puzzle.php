<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puzzle extends Model
{
    use HasFactory;

    protected $fillable = [
        'quest_id',
        'question',
        'answer',
        'hint',
        'time_limit',
        'bonus_points',
        'order',
    ];

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }
}