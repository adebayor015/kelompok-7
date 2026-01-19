@extends('layouts.app') {{-- Asumsikan Anda memiliki layout utama --}}

@section('title', $question['title'])

@section('content')

<main class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-white p-8 rounded-xl shadow-lg">

            <div class="mb-6 pb-4 border-b border-gray-200">
                @if($question->topic)
                    <a href="{{ route('topik.show', $question->topic->slug ?? '#') }}" class="text-sm font-medium bg-blue-100 text-blue-800 px-3 py-1 rounded-full">{{ $question->topic->name }}</a>
                @endif

                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mt-3 mb-4">{{ $question->title }}</h1>

                <p class="text-sm text-gray-600">Ditanyakan oleh
                    @if($question->user)
                        <a href="{{ route('users.show', $question->user->id) }}" class="font-semibold text-blue-600">{{ $question->user->name }}</a>
                    @else
                        <span class="font-semibold">Pengguna tidak ditemukan</span>
                    @endif
                    • {{ $question->created_at->diffForHumans() }}
                </p>

                <p class="mt-4 text-gray-700">{{ $question->content }}</p>
            </div>

        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ $question->answers->count() }} Jawaban</h2>

        <div class="space-y-6">
            @foreach ($question->answers as $answer)
                <div class="p-5 border-l-4 {{ $answer->best ? 'border-green-500 bg-green-50' : 'border-gray-200 bg-gray-50' }} rounded-lg shadow-sm">

                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="font-semibold text-gray-800">
                                @if($answer->user)
                                    <a href="{{ route('users.show', $answer->user->id) }}" class="text-gray-800">{{ $answer->user->name }}</a>
                                @else
                                    Pengguna tidak ditemukan
                                @endif
                                @if ($answer->best)
                                    <span class="ml-2 text-xs font-bold text-green-700 bg-green-200 px-2 py-0.5 rounded-full">✓ Jawaban Terbaik</span>
                                @endif
                            </p>
                            <span class="text-xs text-gray-500">{{ $answer->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="text-gray-700 leading-relaxed">
                        {!! nl2br(e($answer->content)) !!}
                    </div>

                    <div class="mt-3 pt-3 border-t border-gray-100 text-sm text-gray-500 flex space-x-4">
                        <button class="hover:text-blue-600">Suka ({{ $answer->likes ?? 0 }})</button>
                        <button class="hover:text-blue-600">Komentar</button>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Form Tambah Jawaban --}}
        <div class="mt-10 pt-6 border-t border-gray-200">
            <h3 class="text-lg font-semibold mb-3">Tambahkan Jawaban Anda</h3>
            {{-- Isi dengan form: textarea dan tombol submit --}}
            <textarea class="w-full p-3 border rounded-lg focus:ring-blue-500 focus:border-blue-500" rows="4" placeholder="Tulis jawaban terbaik Anda di sini..."></textarea>
            <button class="mt-3 bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-blue-700">Kirim Jawaban</button>
        </div>

    </div>
</main>
@endsection