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
        // 1. Create Admin & Sample Users
        // Admin Utama
        User::create([
            'name' => 'Admin KRFSM',
            'email' => 'admin@krfsm.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Kukuh sebagai User
        User::create([
            'name' => 'Kukuh',
            'email' => 'kukuh@krfsm.com',
            'password' => Hash::make('user123'), // Disamakan agar mudah ingat
            'role' => 'user',
        ]);

        // Farel sebagai User
        User::create([
            'name' => 'Farel',
            'email' => 'farel@krfsm.com',
            'password' => Hash::make('user123'), // Disamakan agar mudah ingat
            'role' => 'user',
        ]);

        // Reza sebagai User Biasa
        $user1 = User::create([
            'name' => 'Reza',
            'email' => 'reza@krfsm.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Suci',
            'email' => 'suci@krfsm.com',
            'password' => Hash::make('user123'), // Disamakan agar mudah ingat
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Mida',
            'email' => 'mida@krfsm.com',
            'password' => Hash::make('user123'), // Disamakan agar mudah ingat
            'role' => 'user',
        ]);

        // 2. Run TopicSeeder
        $this->call([TopicSeeder::class]);

        // 3. Ambil Topik Matematika
        $mtk = Topic::where('slug', 'matematika')->first();
        if (!$mtk) return;

        // --- SEED MATERI VIDEO (SMP & SMA SEMESTER 1-5) ---
        $this->seedMaterials($mtk->id);

        // --- SEED KUMPULAN SOAL & JAWABAN ---
        $this->seedQuestionsAndAnswers($mtk->id, $user1->id);
    }

    private function seedMaterials($topicId)
    {
        $dataMateri = [
            // SMP Semester 1-5
            ['title' => 'Bilangan Bulat & Pecahan (SMP Sem 1)', 'url' => 'https://www.youtube.com/embed/S4_Y9fGZ-mE'],
            ['title' => 'Himpunan & Aljabar (SMP Sem 2)', 'url' => 'https://www.youtube.com/embed/u5NYroWSWj8'],
            ['title' => 'Persamaan & Pertidaksamaan Linear (SMP Sem 3)', 'url' => 'https://www.youtube.com/embed/wJcs0ZzNq4U'],
            ['title' => 'Teorema Pythagoras (SMP Sem 4)', 'url' => 'https://www.youtube.com/embed/a7maYlxsCcI'],
            ['title' => 'Bangun Ruang Sisi Lengkung (SMP Sem 5)', 'url' => 'https://www.youtube.com/embed/N6_R7k2xR48'],
            
            // SMA Semester 1-5
            ['title' => 'Eksponen & Logaritma (SMA Sem 1)', 'url' => 'https://www.youtube.com/embed/W_U68vH_Lno'],
            ['title' => 'Sistem Persamaan Linear Tiga Variabel (SMA Sem 2)', 'url' => 'https://www.youtube.com/embed/0S78M38H9S0'],
            ['title' => 'Fungsi Komposisi & Invers (SMA Sem 3)', 'url' => 'https://www.youtube.com/embed/V6_V6u7a2_8'],
            ['title' => 'Limit Fungsi Aljabar (SMA Sem 4)', 'url' => 'https://www.youtube.com/embed/dQw4w9XcQ'],
            ['title' => 'Turunan / Diferensial (SMA Sem 5)', 'url' => 'https://www.youtube.com/embed/S4_Y9fGZ-mE']
        ];

        foreach ($dataMateri as $m) {
            Material::create([
                'topic_id' => $topicId,
                'title' => $m['title'],
                'slug' => Str::slug($m['title']),
                'content' => 'Pelajari konsep materi ' . $m['title'] . ' melalui video pembahasan ini.',
                'video_url' => $m['url']
            ]);
        }
    }

    private function seedQuestionsAndAnswers($topicId, $userId)
    {
        $soalList = [
            [
                'title' => 'Berapa hasil dari -15 + 8 x (-3)?',
                'content' => 'Mohon bantuannya untuk soal bilangan bulat SMP Kelas 7.',
                'ans' => 'Gunakan urutan operasi (KABATAKU). Kerjakan perkalian dulu: 8 x (-3) = -24. Kemudian: -15 + (-24) = -39.'
            ],
            [
                'title' => 'Tentukan nilai x jika 3x - 5 = 10',
                'content' => 'Soal Aljabar SMP Semester 2.',
                'ans' => 'Pindahkan konstanta: 3x = 10 + 5 -> 3x = 15. Maka x = 15 / 3 = 5.'
            ],
            [
                'title' => 'Sederhanakan bentuk akar sqrt(75)',
                'content' => 'Materi Eksponen SMA Kelas 10.',
                'ans' => 'sqrt(75) = sqrt(25 x 3) = 5 sqrt(3).'
            ],
            [
                'title' => 'Turunan pertama dari f(x) = 4x^3 - 2x + 5',
                'content' => 'Materi Diferensial SMA Semester 5.',
                'ans' => "Gunakan rumus nx^(n-1). f'(x) = 12x^2 - 2."
            ]
        ];

        foreach ($soalList as $s) {
            $q = Question::create([
                'topic_id' => $topicId,
                'user_id' => $userId,
                'title' => $s['title'],
                'content' => $s['content'],
            ]);

            Answer::create([
                'question_id' => $q->id,
                'user_id' => $userId,
                'content' => $s['ans'],
                'best' => true
            ]);
        }
    }
}

        // Materi IPA/Sains
        // --- SEED MATERI UNTUK TOPIK LAIN ---

        // 1. IPA
        $ipa = Topic::where('slug', 'ipa')->first();
        if ($ipa) {
            Material::create([
                'topic_id' => $ipa->id,
                'title' => 'Sistem Pencernaan Manusia',
                'slug' => Str::slug('Sistem Pencernaan Manusia'),
                'content' => 'Video pembahasan anatomi sistem pencernaan.',
                'video_url' => 'https://www.youtube.com/embed/S4_Y9fGZ-mE'
            ]);
            
            Question::create([
                'topic_id' => $ipa->id,
                'user_id' => $user1->id,
                'title' => 'Apa fungsi asam lambung?',
                'content' => 'Mohon penjelasan mengenai HCl di dalam lambung.',
            ]);
        }

        // 2. Bahasa Inggris
        $bing = Topic::where('slug', 'bahasa-inggris')->first();
        if ($bing) {
            Material::create([
                'topic_id' => $bing->id,
                'title' => 'Present Continuous Tense',
                'slug' => Str::slug('Present Continuous Tense'),
                'content' => 'Belajar tenses untuk kejadian yang sedang berlangsung.',
                'video_url' => 'https://www.youtube.com/embed/0S78M38H9S0'
            ]);
        }

        // 3. IPS / Sejarah
        $sejarah = Topic::where('slug', 'sejarah')->first();
        if ($sejarah) {
            Material::create([
                'topic_id' => $sejarah->id,
                'title' => 'Peristiwa Rengasdengklok',
                'slug' => Str::slug('Peristiwa Rengasdengklok'),
                'content' => 'Sejarah kemerdekaan Indonesia.',
                'video_url' => 'https://www.youtube.com/embed/V6_V6u7a2_8'
            ]);
        }

        // 4. PPKN
        $ppkn = Topic::where('slug', 'ppkn')->first();
        if ($ppkn) {
            Material::create([
                'topic_id' => $ppkn->id,
                'title' => 'Nilai-nilai Pancasila',
                'slug' => Str::slug('Nilai-nilai Pancasila'),
                'content' => 'Implementasi Pancasila dalam kehidupan sehari-hari.',
                'video_url' => 'https://www.youtube.com/embed/N6_R7k2xR48'
            ]);
        }
    
