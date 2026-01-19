@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 px-4">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Soal {{ $topic->name }}
        </h1>
        <p class="text-gray-600">Pelajari materi melalui video dan diskusi pertanyaan di bawah ini.</p>
    </div>

    <h2 class="text-xl font-bold mb-4 text-gray-800 flex items-center">
        <svg class="w-6 h-6 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
        </svg>
        Video Pembahasan {{ $topic->name }}
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        @forelse ($materials as $material)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                <div class="aspect-video bg-black">
                    <iframe class="w-full h-full" 
                            src="{{ $material->video_url }}" 
                            title="YouTube video player" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 line-clamp-2">{{ $material->title }}</h3>
                    <p class="text-xs text-blue-600 font-semibold mt-2 uppercase">{{ $topic->name }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl p-8 text-center">
                <p class="text-gray-500">Belum ada video pembahasan untuk topik ini.</p>
            </div>
        @endforelse
    </div>

    <hr class="mb-10 border-gray-200">

    <h2 class="text-xl font-bold mb-6 text-gray-800">Diskusi Soal Terbaru</h2>

    @forelse ($questions as $question)
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-5 hover:border-blue-300 transition">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">
                        {{ $question->title }}
                    </h2>
                    <p class="text-gray-600 mt-2 leading-relaxed">
                        {{ Str::limit($question->content, 150) }}
                    </p>
                </div>
            </div>

            <div class="flex items-center text-sm text-gray-500 mt-4 space-x-4">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    {{ $question->answers->count() }} Jawaban
                </span>
                <span>• {{ $question->created_at->diffForHumans() }}</span>
            </div>

            @if($question->answers->first())
                <div class="mt-4 bg-blue-50 p-4 rounded-lg border-l-4 border-blue-400">
                    <strong class="text-blue-800 text-sm">Cara pengerjaan terbaru:</strong>
                    <p class="text-gray-700 text-sm mt-1 italic">
                        "{{ Str::limit($question->answers->first()->content, 200) }}"
                    </p>
                </div>
            @endif

            <div class="mt-4 flex justify-end">
                <a href="{{ route('questions.show', $question->id) }}"
                   class="text-blue-600 font-bold text-sm hover:underline flex items-center">
                    Lihat Pembahasan Lengkap
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <img src="https://illustrations.popsy.co/gray/searching.svg" class="w-40 mx-auto mb-4" alt="Empty">
            <p class="text-gray-500">Belum ada soal di topik ini. Jadi yang pertama bertanya!</p>
        </div>
    @endforelse

</div>
@endsection