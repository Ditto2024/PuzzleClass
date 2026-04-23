<?php

namespace Database\Seeders;

use App\Models\Puzzle;
use App\Models\Quest;
use App\Models\ShopItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Puzzle::query()->delete();
        Quest::query()->delete();
        ShopItem::query()->delete();

        $quest1 = Quest::create([
            'title' => 'Quest 1 Awakening',
            'description' => 'Difficulty: Easy',
            'reward_points' => 100,
            'reward_xp' => 50,
            'order' => 1,
            'is_active' => true,
        ]);

        $quest2 = Quest::create([
            'title' => 'Quest 2 Logic Gate',
            'description' => 'Difficulty: Medium',
            'reward_points' => 150,
            'reward_xp' => 70,
            'order' => 2,
            'is_active' => true,
        ]);

        $quest3 = Quest::create([
            'title' => 'Quest 3 Find Code',
            'description' => 'Difficulty: Hard',
            'reward_points' => 200,
            'reward_xp' => 100,
            'order' => 3,
            'is_active' => true,
        ]);

        Puzzle::create([
            'quest_id' => $quest1->id,
            'question' => 'Berapa hasil 2 + 2?',
            'answer' => '4',
            'hint' => 'Ini operasi penjumlahan dasar.',
            'time_limit' => 90,
            'bonus_points' => 50,
            'order' => 1,
        ]);

        Puzzle::create([
            'quest_id' => $quest2->id,
            'question' => 'Gerbang logika yang bernilai true jika hanya salah satu input true adalah?',
            'answer' => 'xor',
            'hint' => 'Bukan AND dan bukan OR biasa.',
            'time_limit' => 90,
            'bonus_points' => 70,
            'order' => 1,
        ]);

        Puzzle::create([
            'quest_id' => $quest3->id,
            'question' => 'Kode rahasia manakah yang benar?',
            'answer' => 'alpha-7',
            'hint' => 'Perhatikan angka tengah yang ganjil.',
            'time_limit' => 90,
            'bonus_points' => 100,
            'order' => 1,
        ]);

        ShopItem::create([
            'name' => '+15 Seconds',
            'type' => 'time_boost',
            'value' => 15,
            'price' => 50,
        ]);

        ShopItem::create([
            'name' => '+30 Seconds',
            'type' => 'time_boost',
            'value' => 30,
            'price' => 100,
        ]);

        ShopItem::create([
            'name' => 'Hint Pack',
            'type' => 'hint',
            'value' => 3,
            'price' => 80,
        ]);
    }
}