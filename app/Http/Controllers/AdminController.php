<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Topic;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Admin Dashboard Index
     */
    public function index()
    {
        $total_users = User::count();
        $total_questions = Question::count();
        $total_answers = Answer::count();
        $total_topics = Topic::count();
        $recent_users = User::latest()->take(5)->get();

        return view('admin.index', [
            'total_users' => $total_users,
            'total_questions' => $total_questions,
            'total_answers' => $total_answers,
            'total_topics' => $total_topics,
            'recent_users' => $recent_users,
        ]);
    }

    /**
     * Users Management Page
     */
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users', ['users' => $users]);
    }

    /**
     * Delete User
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting admin account
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak bisa menghapus akun admin!');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus!');
    }

    /**
     * Questions Management Page
     */
    public function questions()
    {
        $questions = Question::with('user')->paginate(15);
        return view('admin.questions', ['questions' => $questions]);
    }

    /**
     * Delete Question
     */
    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return back()->with('success', 'Pertanyaan berhasil dihapus!');
    }

    /**
     * Topics Management Page
     */
    public function topics()
    {
        $topics = Topic::paginate(15);
        return view('admin.topics', ['topics' => $topics]);
    }

    /**
     * Create Topic Page
     */
    public function createTopic()
    {
        return view('admin.create-topic');
    }

    /**
     * Store Topic
     */
    public function storeTopic(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:topics,name',
            'slug' => 'required|string|max:255|unique:topics,slug',
            'description' => 'required|string',
        ]);

        Topic::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.topics')->with('success', 'Topik berhasil ditambahkan!');
    }

    /**
     * Delete Topic
     */
    public function deleteTopic($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();
        return back()->with('success', 'Topik berhasil dihapus!');
    }

    /**
     * Settings Page
     */
    public function settings()
    {
        return view('admin.settings');
    }
}
