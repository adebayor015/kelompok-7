@extends('layouts.app') {{-- Asumsikan Anda memiliki layout utama --}}

@section('title', $question['title'])

@section('content')

<main class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-white p-8 rounded-xl shadow-lg">

        <div class="mb-6 pb-4 border-b border-gray-200">
            <span class="text-sm font-medium bg-blue-100 text-blue-800 px-3 py-1 rounded-full">{{ $question['topic'] }}</span>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mt-3 mb-4">{{ $question['title'] }}</h1>
            <p class="text-sm text-gray-600">Ditanyakan oleh <span class="font-semibold text-blue-600">{{ $question['user'] }}</span> | {{ $question['time'] }}</p>
            
            <p class="mt-4 text-gray-700">
                {{-- Di sini bisa ditambahkan deskripsi/konten pertanyaan yang lebih panjang --}}
                Pertanyaan ini memerlukan pemahaman konsep dasar geometri ruang. Mohon sertakan contoh penerapan yang mudah dipahami oleh pelajar SMP.
            </p>
        </div>

        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ count($question['answers']) }} Jawaban</h2>

        <div class="space-y-6">
            @foreach ($question['answers'] as $answer)
                <div class="p-5 border-l-4 {{ $answer['best'] ? 'border-green-500 bg-green-50' : 'border-gray-200 bg-gray-50' }} rounded-lg shadow-sm">
                    
                    <div class="flex justify-between items-start mb-3">
                        <p class="font-semibold text-gray-800">{{ $answer['user'] }} 
                            @if ($answer['best'])
                                <span class="ml-2 text-xs font-bold text-green-700 bg-green-200 px-2 py-0.5 rounded-full">✓ Jawaban Terbaik</span>
                            @endif
                        </p>
                        <span class="text-xs text-gray-500">Dijawab 3 jam yang lalu</span>
                    </div>

                    <div class="text-gray-700 leading-relaxed">
                        {{ $answer['content'] }}
                    </div>

                    {{-- Form/Tombol untuk Suka/Komentar Jawaban --}}
                    <div class="mt-3 pt-3 border-t border-gray-100 text-sm text-gray-500 flex space-x-4">
                        <button class="hover:text-blue-600">Suka (5)</button>
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