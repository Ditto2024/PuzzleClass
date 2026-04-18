<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quest;
use App\Models\Puzzle;
use App\Models\ShopItem;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $quest = Quest::create([
            'title' => 'Intro Puzzle',
            'description' => 'Latihan dasar logika',
            'reward_points' => 100,
            'reward_xp' => 50,
            'order' => 1,
            'is_active' => true,
        ]);

        Puzzle::create([
            'quest_id' => $quest->id,
            'question' => '2 + 2 = ?',
            'answer' => '4',
            'hint' => 'Ini matematika dasar',
            'time_limit' => 60,
            'bonus_points' => 50,
            'order' => 1,
        ]);

        ShopItem::create([
            'name' => 'Hint +1',
            'type' => 'hint',
            'value' => 1,
            'price' => 20,
        ]);
    }
}