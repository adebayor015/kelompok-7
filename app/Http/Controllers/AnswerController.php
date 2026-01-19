<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Request $request, $id)
    {
        // 1. Validasi
        $request->validate([
            'content' => 'required|min:5',
        ]);

        // 2. Simpan Jawaban
        Answer::create([
            'question_id' => $id,
            'user_id'     => session('user_id'), // Pastikan ini sesuai dengan session loginmu
            'content'     => $request->input('content'),
        ]);

        // 3. Balik lagi ke halaman tadi dengan pesan sukses
        return back()->with('success', 'Jawaban berhasil dikirim!');
    }

}
