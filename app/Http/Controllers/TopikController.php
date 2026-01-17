<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        ];

        $kategoris = ['Matematika', 'IPA', 'IPS', 'Sains', 
        'Bahasa Indonesia', 'Bahasa Inggris', 'Sejarah', 'PPKN', 'Agama'];
        return view('topik', compact('videos', 'kategoris'));
    }
}
