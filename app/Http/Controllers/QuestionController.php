<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Data simulasi (seperti dari model/database)
    private $questions = [
        [
            'id' => 1,
            'title' => 'Apa rumus untuk mencari volume tabung, dan bagaimana cara menerapkannya pada soal?',
            'topic' => 'Matematika', 
            'color' => 'blue', 
            'user' => 'Siswa_Rajin78', 
            'time' => '12 jam yang lalu',
            'answers' => [
                ['user' => 'Guru_Matematika', 'content' => 'Rumus Volume Tabung adalah $V = \pi r^2 t$. Penerapannya melibatkan substitusi nilai jari-jari (r) dan tinggi (t).', 'best' => true],
                ['user' => 'Pintar_MTK', 'content' => 'Jawaban yang lebih praktis: $V = Luas Alas \times Tinggi$.', 'best' => false],
            ],
        ],
        [
            'id' => 2, 
            'title' => 'Jelaskan perbedaan mendasar antara Mitosis dan Meiosis!', 
            'topic' => 'Biologi', 
            'color' => 'green', 
            'user' => 'Pecinta_Sains', 
            'time' => '2 hari yang lalu',
            'answers' => [
                ['user' => 'Dr_Biologi', 'content' => 'Mitosis menghasilkan dua sel anak identik, sedangkan Meiosis menghasilkan empat sel anak non-identik dengan setengah jumlah kromosom.', 'best' => true],
            ],
        ],
        // ... pertanyaan lain
    ];

    /** Menampilkan halaman index (daftar pertanyaan) */
    public function index()
{
    $questions = $this->questions;
    return view('index', compact('questions'));

}



    /** Menampilkan halaman detail pertanyaan */
    public function show($id)
    {
        // Cari pertanyaan berdasarkan ID
        $question = collect($this->questions)->firstWhere('id', (int)$id);
        
        if (!$question) {
            abort(404); // Jika tidak ditemukan, kembalikan 404
        }

        // Kirim data pertanyaan dan jawabannya ke view show
        return view('questions.show', compact('question')); // BENAR, sesuai views/question
    }

    // Di QuestionController.php
public function create()
{
    // View ini akan berisi form untuk membuat pertanyaan baru
    return view('questions.create'); 
}
// QuestionController.php
public function store(Request $request)
{
    // 1. Validasi Data
    $request->validate([
        'title' => 'required|string|max:100',
        'content' => 'required|string|min:10',
        'topic_id' => 'required|integer|exists:topics,id', // Jika sudah ada DB
    ]);

    // 2. Simpan ke Database (simulasi)
    // Question::create($request->all());

    // 3. Redirect ke halaman pertanyaan yang baru dibuat
    return redirect()->route('home')->with('success', 'Pertanyaan Anda berhasil diajukan!');
}
}
