<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Question;use Illuminate\Http\Request;

class TopikController extends Controller
{
    public function index()
    {
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
            [
                'title' => 'Sistem Pencernaan Manusia',
                'youtube_id' => 'abcd1234',
                'mapel' => 'IPA'
            ]
        ];

        $kategoris = ['Matematika', 'IPA', 'IPS', 'Sains', 
        'Bahasa Indonesia', 'Bahasa Inggris', 'Sejarah', 'PPKN'];
        return view('topik', compact('videos', 'kategoris'));
    }
    public function show($slug)
    {
        $topic = Topic::where('slug', $slug)->firstOrFail();

        $questions = Question::with(['user', 'answers'])
            ->where('topic_id', $topic->id)
            ->latest()
            ->get();

        return view('topik-detail', compact('topic', 'questions'));
    }
}
