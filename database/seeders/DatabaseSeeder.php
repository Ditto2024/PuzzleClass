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
            'title' => 'Algoritma Dasar',
            'description' => 'Memahami konsep dasar algoritma',
            'reward_points' => 100,
            'reward_xp' => 50,
            'order' => 1,
            'is_active' => true,
        ]);

        $quest2 = Quest::create([
            'title' => 'Logika Algoritma',
            'description' => 'Percabangan & logika sederhana',
            'reward_points' => 150,
            'reward_xp' => 70,
            'order' => 2,
            'is_active' => true,
        ]);

        $quest3 = Quest::create([
            'title' => 'Loop & Urutan',
            'description' => 'Perulangan dan urutan',
            'reward_points' => 200,
            'reward_xp' => 100,
            'order' => 3,
            'is_active' => true,
        ]);

        Puzzle::insert([
            ['quest_id' => $quest1->id, 'question' => 'Apa itu algoritma?', 'answer' => 'langkah-langkah', 'hint' => 'Sesuatu yang berurutan untuk menyelesaikan masalah', 'time_limit' => 90, 'bonus_points' => 20, 'order' => 1],
            ['quest_id' => $quest1->id, 'question' => 'Algoritma harus bersifat?', 'answer' => 'terurut', 'hint' => 'Tidak boleh acak', 'time_limit' => 90, 'bonus_points' => 20, 'order' => 2],
            ['quest_id' => $quest1->id, 'question' => 'Algoritma digunakan untuk?', 'answer' => 'menyelesaikan masalah', 'hint' => 'Tujuan utamanya', 'time_limit' => 90, 'bonus_points' => 20, 'order' => 3],
            ['quest_id' => $quest1->id, 'question' => 'Langkah algoritma harus?', 'answer' => 'jelas', 'hint' => 'Tidak ambigu', 'time_limit' => 90, 'bonus_points' => 20, 'order' => 4],
            ['quest_id' => $quest1->id, 'question' => 'Algoritma berakhir ketika?', 'answer' => 'selesai', 'hint' => 'Ada akhir', 'time_limit' => 90, 'bonus_points' => 20, 'order' => 5],

            ['quest_id' => $quest2->id, 'question' => 'Jika 5 > 3 maka hasilnya?', 'answer' => 'true', 'hint' => 'Benar atau salah?', 'time_limit' => 90, 'bonus_points' => 25, 'order' => 1],
            ['quest_id' => $quest2->id, 'question' => 'Jika 2 == 3 maka?', 'answer' => 'false', 'hint' => 'Bandingkan', 'time_limit' => 90, 'bonus_points' => 25, 'order' => 2],
            ['quest_id' => $quest2->id, 'question' => 'Percabangan disebut juga?', 'answer' => 'if', 'hint' => 'kata kunci pemrograman', 'time_limit' => 90, 'bonus_points' => 25, 'order' => 3],
            ['quest_id' => $quest2->id, 'question' => 'Jika kondisi salah maka gunakan?', 'answer' => 'else', 'hint' => 'pasangan if', 'time_limit' => 90, 'bonus_points' => 25, 'order' => 4],
            ['quest_id' => $quest2->id, 'question' => 'True berarti?', 'answer' => 'benar', 'hint' => 'arti bahasa indonesia', 'time_limit' => 90, 'bonus_points' => 25, 'order' => 5],

            ['quest_id' => $quest3->id, 'question' => 'Perulangan disebut?', 'answer' => 'loop', 'hint' => 'digunakan berulang', 'time_limit' => 90, 'bonus_points' => 30, 'order' => 1],
            ['quest_id' => $quest3->id, 'question' => 'Loop untuk jumlah tertentu?', 'answer' => 'for', 'hint' => 'for loop', 'time_limit' => 90, 'bonus_points' => 30, 'order' => 2],
            ['quest_id' => $quest3->id, 'question' => 'Loop selama kondisi benar?', 'answer' => 'while', 'hint' => 'while loop', 'time_limit' => 90, 'bonus_points' => 30, 'order' => 3],
            ['quest_id' => $quest3->id, 'question' => 'Urutan langkah disebut?', 'answer' => 'sequence', 'hint' => 'bahasa inggris', 'time_limit' => 90, 'bonus_points' => 30, 'order' => 4],
            ['quest_id' => $quest3->id, 'question' => 'Loop berhenti jika?', 'answer' => 'false', 'hint' => 'kondisi berhenti', 'time_limit' => 90, 'bonus_points' => 30, 'order' => 5],
        ]);

        ShopItem::create([
            'name' => 'Hint +1',
            'type' => 'hint',
            'value' => 1,
            'price' => 20
        ]);

        ShopItem::create([
            'name' => '+15 Seconds',
            'type' => 'time_boost',
            'value' => 15,
            'price' => 50
        ]);

        ShopItem::create([
            'name' => '+30 Seconds',
            'type' => 'time_boost',
            'value' => 30,
            'price' => 100
        ]);
    }
}