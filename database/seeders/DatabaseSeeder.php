<?php

namespace Database\Seeders;

use App\Models\Puzzle;
use App\Models\Quest;
use App\Models\ShopItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Puzzle::truncate();
        Quest::truncate();
        ShopItem::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        ShopItem::create([
            'name' => 'Hint +1',
            'type' => 'hint',
            'value' => 1,
            'price' => 20,
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

        $quest1 = Quest::create([
            'title' => 'Quest 1: Dasar Algoritma',
            'description' => 'Mengenal pengertian dan ciri-ciri algoritma.',
            'reward_points' => 100,
            'reward_xp' => 50,
            'order' => 1,
            'is_active' => true,
        ]);

        $this->createPuzzles($quest1->id, [
            ['Apa nama langkah-langkah terurut untuk menyelesaikan masalah?', 'algoritma', 'Dimulai huruf A'],
            ['Algoritma harus memiliki urutan yang jelas. Benar atau salah?', 'benar', 'Jawab benar/salah'],
            ['Dalam algoritma, instruksi harus mudah dipahami dan tidak membingungkan. Disebut sifat apa?', 'jelas', 'Kata lainnya tidak ambigu'],
            ['Algoritma biasanya memiliki input, proses, dan apa?', 'output', 'Hasil akhir'],
            ['Contoh algoritma sehari-hari adalah langkah-langkah membuat apa?', 'teh', 'Minuman sederhana'],
        ]);

        $quest2 = Quest::create([
            'title' => 'Quest 2: Urutan Langkah',
            'description' => 'Memahami urutan instruksi dalam algoritma.',
            'reward_points' => 150,
            'reward_xp' => 70,
            'order' => 2,
            'is_active' => true,
        ]);

        $this->createPuzzles($quest2->id, [
            ['Langkah pertama sebelum menjalankan solusi disebut tahap apa?', 'awal', 'Kebalikan dari akhir'],
            ['Jika langkah algoritma tertukar, hasilnya bisa menjadi apa?', 'salah', 'Tidak benar'],
            ['Urutan instruksi dalam algoritma harus bersifat?', 'terurut', 'Tidak acak'],
            ['Simbol panah pada flowchart biasanya menunjukkan apa?', 'alur', 'Arah proses'],
            ['Algoritma yang baik harus berakhir setelah sejumlah langkah. Disebut sifat apa?', 'terbatas', 'Tidak berjalan selamanya'],
        ]);

        $quest3 = Quest::create([
            'title' => 'Quest 3: Pseudocode dan Flowchart',
            'description' => 'Mengenal pseudocode dan flowchart sederhana.',
            'reward_points' => 200,
            'reward_xp' => 90,
            'order' => 3,
            'is_active' => true,
        ]);

        $this->createPuzzles($quest3->id, [
            ['Penulisan algoritma dengan bahasa sederhana mirip kode disebut apa?', 'pseudocode', 'Pseudo + code'],
            ['Diagram alur untuk menggambarkan algoritma disebut apa?', 'flowchart', 'Flow artinya alur'],
            ['Simbol oval pada flowchart biasanya berarti mulai atau apa?', 'selesai', 'Akhir proses'],
            ['Simbol jajar genjang pada flowchart biasanya digunakan untuk input dan apa?', 'output', 'Hasil keluaran'],
            ['Simbol belah ketupat pada flowchart biasanya digunakan untuk apa?', 'keputusan', 'Ya atau tidak'],
        ]);
    }

    private function createPuzzles(int $questId, array $puzzles): void
    {
        foreach ($puzzles as $index => $puzzle) {
            Puzzle::create([
                'quest_id' => $questId,
                'question' => $puzzle[0],
                'answer' => $puzzle[1],
                'hint' => $puzzle[2],
                'time_limit' => 20,
                'bonus_points' => 50,
                'order' => $index + 1,
            ]);
        }
    }
}