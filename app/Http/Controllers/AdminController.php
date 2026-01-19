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
     * Questions Management Page
     */
    public function questions()
    {
        $questions = Question::with('user')->paginate(15);
        return view('admin.questions', ['questions' => $questions]);
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
     * Settings Page
     */
    public function settings()
    {
        return view('admin.settings');
    }
}
