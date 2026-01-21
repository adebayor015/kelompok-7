@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ url()->previous() }}" class="text-blue-500 hover:underline mb-4 inline-block">← Kembali</a>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        {{-- Video --}}
        <div class="aspect-video w-full">
            <iframe class="w-full h-full" src="{{ $materi->video_url }}" frameborder="0" allowfullscreen></iframe>
        </div>

        {{-- Teks Pembahasan --}}
        <div class="p-8">
            <h1 class="text-3xl font-bold mb-4">{{ $materi->title }}</h1>
            <div class="prose max-w-none text-gray-700 whitespace-pre-line">
                {{ $materi->content }}
            </div>
        </div>
    </div>
</div>
@endsection