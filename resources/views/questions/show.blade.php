@extends('layouts.app')

@section('title', $question->title)

@section('content')
<main class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-white p-8 rounded-xl shadow-lg">

        <div class="mb-6 pb-4 border-b border-gray-200">
            @if($question->topic)
                <a href="{{ route('topik.show', $question->topic->slug ?? '#') }}" class="text-sm font-medium bg-blue-100 text-blue-800 px-3 py-1 rounded-full">{{ $question->topic->name }}</a>
            @endif

            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mt-3 mb-4">{{ $question->title }}</h1>

            <div class="flex items-center space-x-3 text-sm text-gray-600">
                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-xs">
                    {{ $question->user ? strtoupper(substr($question->user->name, 0, 1)) : '?' }}
                </div>
                <p>
                    Ditanyakan oleh
                    @if($question->user)
                        <a href="{{ route('users.show', $question->user->id) }}" class="font-semibold text-blue-600 hover:underline">{{ $question->user->name }}</a>
                    @else
                        <span class="font-semibold">Pengguna tidak ditemukan</span>
                    @endif
                    • {{ $question->created_at->diffForHumans() }}
                </p>
            </div>

            <div class="mt-6 text-gray-700 leading-relaxed text-lg">
                {{ $question->content }}
            </div>
        </div>

        <h2 id="answers-section" class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
            {{ $question->answers->count() }} Jawaban
        </h2>

        <div class="space-y-6">
            @forelse ($question->answers as $answer)
                <div class="p-6 border-l-4 {{ $answer->best ? 'border-green-500 bg-green-50' : 'border-gray-200 bg-gray-50' }} rounded-r-xl shadow-sm transition hover:shadow-md">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold text-sm">
                                {{ $answer->user ? strtoupper(substr($answer->user->name, 0, 1)) : '?' }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 leading-none">
                                    @if($answer->user)
                                        <a href="{{ route('users.show', $answer->user->id) }}" class="hover:text-blue-600 transition">{{ $answer->user->name }}</a>
                                    @else
                                        Pengguna tidak ditemukan
                                    @endif
                                </p>
                                <span class="text-xs text-gray-500">{{ $answer->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @if ($answer->best)
                            <span class="text-xs font-bold text-green-700 bg-green-200 px-3 py-1 rounded-full flex items-center shadow-sm">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                                Jawaban Terbaik
                            </span>
                        @endif
                    </div>

                    <div class="text-gray-700 leading-relaxed prose max-w-none">
                        {!! nl2br(e($answer->content)) !!}
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                    <p class="text-gray-500 italic">Belum ada jawaban. Jadilah yang pertama menjawab!</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12 pt-8 border-t border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Tambahkan Jawaban Anda
            </h3>

            {{-- Alert Success --}}
            @if(session('success'))
                <div id="success-notif" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex justify-between items-center animate-bounce">
                    <span><strong>Sukses!</strong> {{ session('success') }}</span>
                    <button onclick="document.getElementById('success-notif').remove()" class="text-green-900 font-bold">&times;</button>
                </div>
            @endif

            <form action="{{ route('answers.store', $question->id) }}" method="POST" class="group">
                @csrf
                <div class="mb-4">
                    <textarea 
                        name="content" 
                        class="w-full p-4 border-2 border-gray-100 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all @error('content') border-red-500 @enderror" 
                        rows="5" 
                        placeholder="Tulis penjelasan lengkap Anda di sini..."
                        required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white font-bold px-8 py-3 rounded-xl hover:bg-blue-700 transition transform active:scale-95 shadow-lg shadow-blue-200 flex items-center">
                        Kirim Jawaban
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

    </div>
</main>
@endsection