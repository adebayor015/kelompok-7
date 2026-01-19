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

    // 📝 EDIT PERTANYAAN
    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $topics = Topic::all();
        return view('questions.edit', compact('question', 'topics'));
    }

    // 💾 UPDATE PERTANYAAN
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:100',
            'content' => 'required|min:10',
            'topic_id' => 'required|exists:topics,id',
        ]);

        $question = Question::findOrFail($id);
        $question->update([
            'title'    => $request->input('title'),
            'content'  => $request->input('content'),
            'topic_id' => $request->input('topic_id'),
        ]);

        return redirect()
            ->route('home')
            ->with('success', 'Pertanyaan Anda berhasil diperbarui!');
    }

    // 🗑️ HAPUS PERTANYAAN (TAMBAHKAN INI)
    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        // Optional: Cek apakah user yang login adalah pemilik pertanyaan
        if (session('user_id') !== $question->user_id) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus ini.');
        }

        $question->delete();

        return redirect()
            ->route('home')
            ->with('success', 'Pertanyaan berhasil dihapus!');
    }
}