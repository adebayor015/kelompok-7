<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Question;
use App\Models\Material; // Pastikan Model Material sudah di-import
use Illuminate\Http\Request;

class TopikController extends Controller
{
    public function index()
    {
        // Data video static untuk halaman depan (sesuai kode yang kamu paste)
        $videos = [
            [
                'title' => 'Pembahasan Soal Volume Tabung',
                'youtube_id' => 'a7maYlxsCcI',
                'mapel' => 'Matematika'
            ],
            [
                'title' => 'Cara Cepat Pecahan',
                'youtube_id' => 'u5NYroWSWj8',
                'mapel' => 'Matematika'
            ],
            [
                'title' => 'Persamaan Linear',
                'youtube_id' => 'wJcs0ZzNq4U',
                'mapel' => 'Matematika'
            ],
        ];

        $kategoris = [
            'Matematika', 'IPA', 'IPS', 'Sains', 
            'Bahasa Indonesia', 'Bahasa Inggris', 'Sejarah', 'PPKN', 'Agama'
        ];

        return view('topik', compact('videos', 'kategoris'));
    }

    public function show($slug)
    {
        // 1. Ambil data topik berdasarkan slug
        // Kita gunakan 'with' agar data materi dan pertanyaan terpanggil sekaligus
        $topic = Topic::with(['materials', 'questions.user', 'questions.answers'])
            ->where('slug', $slug)
            ->firstOrFail();

        // 2. Ambil data questions yang ada di topik ini, urutkan dari yang terbaru
        $questions = $topic->questions()->latest()->get();

        // 3. Ambil data materials (video) yang nempel ke topik ini
        $materials = $topic->materials;

        // 4. Return ke view 'topik-detail' (sesuai kode kamu)
        return view('topik-detail', compact('topic', 'questions', 'materials'));
    }
}