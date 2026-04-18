<?php

namespace Database\Seeders;

use App\Models\Quest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestSeeder extends Seeder
{
    public function run(): void
    {
        Quest::insert([
            [
                'title' => 'Quest 1: Klasifikasi',
                'description' => 'Selesaikan puzzle klasifikasi pertama.',
                'reward_points' => 100,
                'reward_xp' => 50,
                'order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Quest 2: Logic Gate',
                'description' => 'Uji logika dan jawab puzzle logic gate.',
                'reward_points' => 150,
                'reward_xp' => 70,
                'order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Quest 3: Final Code',
                'description' => 'Masukkan kode akhir untuk menyelesaikan tantangan.',
                'reward_points' => 200,
                'reward_xp' => 100,
                'order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}