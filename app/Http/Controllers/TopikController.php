<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Material;
use Illuminate\Http\Request;

class TopikController extends Controller
{
    public function index()
    {
        // AMBIL DARI DATABASE: Agar punya properti 'slug' dan 'name'
        $kategoris = Topic::all();

        // AMBIL DARI DATABASE: Agar punya kolom 'video_url' yang sudah kita seed
        // Kita ambil semua material yang ada videonya
        $videos = Material::with('topic')->whereNotNull('video_url')->get();

        return view('topik', compact('videos', 'kategoris'));
    }

    public function show($slug)
    {
        $topic = Topic::with(['materials', 'questions.user'])
                      ->where('slug', $slug)
                      ->firstOrFail();

        $questions = $topic->questions()->latest()->get();
        $materials = $topic->materials;

        return view('topik-detail', compact('topic', 'questions', 'materials'));
    }

    public function showMaterial($topic_slug, $material_slug)
    {
        $topic = Topic::where('slug', $topic_slug)->firstOrFail();
        $materi = Material::where('slug', $material_slug)->firstOrFail();

        return view('materi_detail', compact('topic', 'materi'));
    }
}