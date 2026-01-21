<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Topic;
use App\Models\Material;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create All Users (Pastikan tidak ada duplikat email)
        $admin = User::firstOrCreate(
            ['email' => 'admin@krfsm.com'],
            ['name' => 'Admin KRFSM', 'password' => Hash::make('admin123'), 'role' => 'admin']
        );

        $kukuh = User::firstOrCreate(['email' => 'kukuh@krfsm.com'], ['name' => 'Kukuh', 'password' => Hash::make('user123'), 'role' => 'user']);
        $farel = User::firstOrCreate(['email' => 'farel@krfsm.com'], ['name' => 'Farel', 'password' => Hash::make('user123'), 'role' => 'user']);
        $reza = User::firstOrCreate(['email' => 'reza@krfsm.com'], ['name' => 'Reza', 'password' => Hash::make('user123'), 'role' => 'user']);
        $suci = User::firstOrCreate(['email' => 'suci@krfsm.com'], ['name' => 'Suci', 'password' => Hash::make('user123'), 'role' => 'user']);
        $mida = User::firstOrCreate(['email' => 'mida@krfsm.com'], ['name' => 'Mida', 'password' => Hash::make('user123'), 'role' => 'user']);

        // 2. Jalankan TopicSeeder (Opsional jika sudah pakai firstOrCreate di bawah)
        $this->call([TopicSeeder::class]);

        // 3. Pastikan Topik Ada Menggunakan firstOrCreate agar tidak 404 (Not Found)
        $mtk = Topic::firstOrCreate(['slug' => 'matematika'], ['name' => 'Matematika']);
        $ipa = Topic::firstOrCreate(['slug' => 'ipa'], ['name' => 'IPA']);
        $bing = Topic::firstOrCreate(['slug' => 'bahasa-inggris'], ['name' => 'Bahasa Inggris']);
        $sejarah = Topic::firstOrCreate(['slug' => 'sejarah'], ['name' => 'Sejarah']);
        $ppkn = Topic::firstOrCreate(['slug' => 'ppkn'], ['name' => 'PPKN']);

        // --- SEED MATERI MATEMATIKA ---
        $this->seedMaterials($mtk->id);
        $this->seedQuestionsAndAnswers($mtk->id, $reza->id);

        // --- SEED MATERI IPA ---
        Material::updateOrCreate(
            ['slug' => Str::slug('Sistem Pencernaan Manusia')],
            [
                'topic_id' => $ipa->id,
                'title' => 'Sistem Pencernaan Manusia',
                'content' => 'Sistem pencernaan manusia terdiri dari mulut, kerongkongan, lambung, usus halus, usus besar, dan anus.',
                'video_url' => 'https://www.youtube.com/embed/8gvvB9POz6c'
            ]
        );

        // --- SEED MATERI BAHASA INGGRIS ---
        Material::updateOrCreate(
            ['slug' => Str::slug('Present Continuous Tense')],
            [
                'topic_id' => $bing->id,
                'title' => 'Present Continuous Tense',
                'content' => 'Belajar tenses untuk kejadian yang sedang berlangsung.',
                'video_url' => 'https://www.youtube.com/embed/0S78M38H9S0'
            ]
        );

        // --- SEED MATERI SEJARAH ---
        Material::updateOrCreate(
            ['slug' => Str::slug('Peristiwa Rengasdengklok')],
            [
                'topic_id' => $sejarah->id,
                'title' => 'Peristiwa Rengasdengklok',
                'content' => 'Sejarah penting menjelang proklamasi kemerdekaan Indonesia.',
                'video_url' => 'https://www.youtube.com/embed/V6_V6u7a2_8'
            ]
        );

        // --- SEED MATERI PPKN ---
        Material::updateOrCreate(
            ['slug' => Str::slug('Nilai-nilai Pancasila')],
            [
                'topic_id' => $ppkn->id,
                'title' => 'Nilai-nilai Pancasila',
                'content' => 'Mempelajari implementasi nilai luhur Pancasila dalam kehidupan berbangsa dan bernegara.',
                'video_url' => 'https://www.youtube.com/embed/N6_R7k2xR48'
            ]
        );
    }

    private function seedMaterials($topicId)
    {
        $dataMateri = [
            ['title' => 'Bilangan Bulat & Pecahan (SMP Sem 1)', 'url' => 'https://www.youtube.com/embed/S4_Y9fGZ-mE'],
            ['title' => 'Himpunan & Aljabar (SMP Sem 2)', 'url' => 'https://www.youtube.com/embed/u5NYroWSWj8'],
            ['title' => 'Persamaan & Pertidaksamaan Linear (SMP Sem 3)', 'url' => 'https://www.youtube.com/embed/wJcs0ZzNq4U'],
            ['title' => 'Eksponen & Logaritma (SMA Sem 1)', 'url' => 'https://www.youtube.com/embed/W_U68vH_Lno'],
        ];

        foreach ($dataMateri as $m) {
            Material::updateOrCreate(
                ['slug' => Str::slug($m['title'])],
                [
                    'topic_id' => $topicId,
                    'title' => $m['title'],
                    'content' => 'Pelajari konsep materi ' . $m['title'] . ' melalui video ini.',
                    'video_url' => $m['url']
                ]
            );
        }
    }

    private function seedQuestionsAndAnswers($topicId, $userId)
    {
        $q = Question::firstOrCreate(
            ['title' => 'Berapa hasil dari -15 + 8 x (-3)?'],
            [
                'topic_id' => $topicId,
                'user_id' => $userId,
                'content' => 'Mohon bantuannya untuk soal bilangan bulat SMP Kelas 7.',
            ]
        );

        Answer::firstOrCreate(
            ['question_id' => $q->id, 'content' => 'Hasilnya adalah -39. Kerjakan perkalian dulu baru penjumlahan.'],
            ['user_id' => $userId, 'best' => true]
        );
    }
}