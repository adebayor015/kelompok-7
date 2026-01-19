@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10">

    <h1 class="text-3xl font-bold mb-6">
        Soal {{ $topic->name }}
    </h1>

    @forelse ($questions as $question)
        <div class="bg-white p-5 rounded-lg shadow mb-4">
            <h2 class="text-lg font-semibold">
                {{ $question->title }}
            </h2>

            <p class="text-gray-600 mt-2">
                {{ Str::limit($question->content, 150) }}
            </p>

            <p class="text-sm text-gray-500 mt-2">
                {{ $question->answers->count() }} Jawaban
            </p>

            @if($question->answers->first())
                <div class="mt-3 bg-gray-50 p-3 rounded">
                    <strong>Cara pengerjaan:</strong>
                    <p>
                        {{ Str::limit($question->answers->first()->content, 200) }}
                    </p>
                </div>
            @endif

            <a href="{{ route('questions.show', $question->id) }}"
               class="text-blue-600 mt-3 inline-block">
               Lihat Detail →
            </a>
        </div>
    @empty
        <p>Belum ada soal di topik ini.</p>
    @endforelse

</div>
@endsection
