<?php

namespace App\Http\Controllers;
use App\Models\Topic;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // 🏠 BERANDA
    public function index()
    {
        $questions = Question::with(['user','topic','answers'])
            ->latest()
            ->get();

        return view('index', compact('questions'));
    }

    // ➕ FORM BUAT PERTANYAAN
 

public function create()
{
    $topics = Topic::withCount('questions')->get();
    return view('questions.create', compact('topics'));
}


    // 💾 SIMPAN PERTANYAAN
    public function store(Request $request)
    {
    

        $request->validate([
            'title' => 'required|max:100',
            'content' => 'required|min:10',
            'topic_id' => 'required|exists:topics,id',
        ]);

        Question::create([
        'user_id'  => session('user_id'),
        'title'    => $request->input('title'),
        'content'  => $request->input('content'),
        'topic_id' => $request->input('topic_id'),
        ]);

        return redirect()
            ->route('home')
            ->with('success', 'Pertanyaan Anda berhasil diajukan!');
    }

    // 📄 DETAIL PERTANYAAN
    public function show($id)
    {
        $question = Question::with(['user','answers'])
            ->findOrFail($id);

        return view('questions.show', compact('question'));
    }

    public function byKategori($kategori)
{
    $questions = Question::with(['user','topic','answers'])
        ->whereHas('topic', function($q) use ($kategori) {
            $q->where('kategori', $kategori);
        })
        ->latest()
        ->get();

    return view('topik', compact('questions','kategori'));
}



}
