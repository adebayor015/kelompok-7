<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    // 🏠 BERANDA - Diperbarui agar menghitung Like secara otomatis
    public function index()
    {
        $userId = session('user_id');

        $questions = Question::with(['user', 'topic', 'answers'])
            ->withCount('likes') // Menghasilkan variabel $question->likes_count otomatis
            ->addSelect([
                // Cek apakah user yang sedang login sudah like pertanyaan ini
                'is_liked' => DB::table('likes')
                    ->select('id')
                    ->whereColumn('question_id', 'questions.id')
                    ->where('user_id', $userId)
                    ->limit(1)
            ])
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

    // 📄 DETAIL PERTANYAAN - Diperbarui juga untuk fitur Like
    public function show($id)
    {
        $userId = session('user_id');

        $question = Question::with(['user', 'answers'])
            ->withCount('likes')
            ->addSelect([
                'is_liked' => DB::table('likes')
                    ->select('id')
                    ->whereColumn('question_id', 'questions.id')
                    ->where('user_id', $userId)
                    ->limit(1)
            ])
            ->findOrFail($id);

        return view('questions.show', compact('question'));
    }

    public function byKategori($kategori)
    {
        $questions = Question::with(['user', 'topic', 'answers'])
            ->whereHas('topic', function ($q) use ($kategori) {
                $q->where('kategori', $kategori);
            })
            ->latest()
            ->get();

        return view('topik', compact('questions', 'kategori'));
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

    // 🗑️ HAPUS PERTANYAAN
    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        if (session('user_id') !== $question->user_id) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus ini.');
        }

        $question->delete();

        return redirect()
            ->route('home')
            ->with('success', 'Pertanyaan berhasil dihapus!');
    }

    // ❤️ TOGGLE LIKE (AJAX)
    public function toggleLike($id)
    {
        $userId = session('user_id');

        // Jika user tidak login, kirim error 401 agar ditangkap JavaScript
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $like = DB::table('likes')
            ->where('user_id', $userId)
            ->where('question_id', $id)
            ->first();

        if ($like) {
            DB::table('likes')->where('id', $like->id)->delete();
            $isLiked = false;
        } else {
            DB::table('likes')->insert([
                'user_id' => $userId,
                'question_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $isLiked = true;
        }

        $count = DB::table('likes')->where('question_id', $id)->count();

        return response()->json([
            'success' => true,
            'is_liked' => $isLiked,
            'likes_count' => $count
        ]);
    }
}