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
        // 1. Create All Users
        User::firstOrCreate(['email' => 'admin@krfsm.com'], ['name' => 'Admin KRFSM', 'password' => Hash::make('admin123'), 'role' => 'admin']);
        $reza = User::firstOrCreate(['email' => 'reza@krfsm.com'], ['name' => 'Reza', 'password' => Hash::make('user123'), 'role' => 'user']);
        User::firstOrCreate(['email' => 'kukuh@krfsm.com'], ['name' => 'Kukuh', 'password' => Hash::make('user123'), 'role' => 'user']);
        User::firstOrCreate(['email' => 'farel@krfsm.com'], ['name' => 'Farel', 'password' => Hash::make('user123'), 'role' => 'user']);
        User::firstOrCreate(['email' => 'suci@krfsm.com'], ['name' => 'Suci', 'password' => Hash::make('user123'), 'role' => 'user']);
        User::firstOrCreate(['email' => 'mida@krfsm.com'], ['name' => 'Mida', 'password' => Hash::make('user123'), 'role' => 'user']);

        // 2. Jalankan TopicSeeder (Jika ada)
        if (class_exists(TopicSeeder::class)) {
            $this->call([TopicSeeder::class]);
        }

        // 3. Pastikan Topik Ada
        $mtk = Topic::firstOrCreate(['slug' => 'matematika'], ['name' => 'Matematika']);
        $ipa = Topic::firstOrCreate(['slug' => 'ipa'], ['name' => 'IPA']);
        $bing = Topic::firstOrCreate(['slug' => 'bahasa-inggris'], ['name' => 'Bahasa Inggris']);
        $sejarah = Topic::firstOrCreate(['slug' => 'sejarah'], ['name' => 'Sejarah']);
        $ppkn = Topic::firstOrCreate(['slug' => 'ppkn'], ['name' => 'PPKN']);
        $ips = Topic::firstOrCreate(['slug' => 'ips'], ['name' => 'IPS']);
        $sains = Topic::firstOrCreate(['slug' => 'sains'], ['name' => 'Sains']);
        $bindonesia = Topic::firstOrCreate(['slug' => 'bahasa-indonesia'], ['name' => 'Bahasa Indonesia']);

        // --- SEED MATERI MATEMATIKA ---
        $this->seedMaterials($mtk->id);
        $this->seedQuestionsAndAnswers($mtk->id, $reza->id);

        // --- SEED MATERI IPA (Metabolisme Enzim) ---
        Material::updateOrCreate(
            ['slug' => Str::slug('Sistem Metabolisme Enzim')],
            [
                'topic_id' => $ipa->id,
                'title' => 'Sistem Metabolisme Enzim',
                'content' => 'Mempelajari biokatalisator dalam tubuh manusia.',
                'video_url' => 'https://www.youtube.com/embed/UJltOSp7eZ8'
            ]
        );

        // --- SEED MATERI BAHASA INGGRIS ---
        Material::updateOrCreate(
            ['slug' => Str::slug('Present Continuous Tense')],
            [
                'topic_id' => $bing->id,
                'title' => 'Present Continuous Tense',
                'content' => 'Belajar tenses untuk kejadian yang sedang berlangsung.',
                'video_url' => 'https://www.youtube.com/embed/pGkmRjXiKq4'
            ]
        );

        // --- SEED MATERI SEJARAH (Konsep Dasar Sejarah) ---
        Material::updateOrCreate(
            ['slug' => Str::slug('Konsep Dasar Sejarah')],
            [
                'topic_id' => $sejarah->id,
                'title' => 'Konsep Dasar Sejarah',
                'content' => 'Memahami konsep manusia, ruang, dan waktu dalam sejarah.',
                'video_url' => 'https://www.youtube.com/embed/MD56RYVl-pU'
            ]
        );

        // --- SEED MATERI PPKN (Hak dan Kewajiban) ---
        Material::updateOrCreate(
            ['slug' => Str::slug('Kasus Pelanggaran Hak')],
            [
                'topic_id' => $ppkn->id,
                'title' => 'Kasus Pelanggaran Hak',
                'content' => 'Mempelajari kasus-kasus pelanggaran dan pengingkaran kewajiban warga negara.',
                'video_url' => 'https://www.youtube.com/embed/MRXMy_7_HD0'
            ]
        );

        // --- SEED MATERI IPS ---
        Material::updateOrCreate(
            ['slug' => Str::slug('Keragaman Budaya Indonesia')],
            [
                'topic_id' => $ips->id,
                'title' => 'Keragaman Budaya Indonesia',
                'content' => 'Mengenal berbagai budaya dan tradisi di Indonesia.',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'
            ]
        );

        // --- SEED MATERI SAINS (Materi Genetik) ---
        Material::updateOrCreate(
            ['slug' => Str::slug('Materi Genetik Dasar')],
            [
                'topic_id' => $sains->id,
                'title' => 'Materi Genetik Dasar',
                'content' => 'Memahami DNA, RNA, dan Kromosom.',
                'video_url' => 'https://www.youtube.com/embed/pRLzqHAWTcs'
            ]
        );

        // --- SEED MATERI BAHASA INDONESIA (Kalimat Efektif) ---
        Material::updateOrCreate(
            ['slug' => Str::slug('Analisis Kalimat Efektif')],
            [
                'topic_id' => $bindonesia->id,
                'title' => 'Analisis Kalimat Efektif',
                'content' => 'Belajar membuat kalimat yang benar dan efektif sesuai kaidah.',
                'video_url' => 'https://www.youtube.com/embed/wKfPJdjiauw'
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
            ['user_id' => $userId, 'is_best' => true] 
        );
    }
}