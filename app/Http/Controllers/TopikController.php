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
    // Mengambil topik tanpa mempedulikan siapa yang login
    $topic = Topic::with(['materials', 'questions.user'])
                  ->where('slug', $slug)
                  ->firstOrFail();

    $questions = $topic->questions()->latest()->get();
    $materials = $topic->materials;

    return view('topik-detail', compact('topic', 'questions', 'materials'));
}
}