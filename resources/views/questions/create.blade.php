@extends('layouts.app') 

@section('title', 'Tanya Pertanyaan Baru')

@section('content')

<main class="max-w-3xl mx-auto px-4 py-10">
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">

        <h1 class="text-2xl font-bold text-blue-700 mb-6 border-b pb-4">🗣️ Ajukan Pertanyaan Baru</h1>

        {{-- Form ini akan mengirim data ke QuestionController@store --}}
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf {{-- Wajib ada di Laravel untuk keamanan --}}

            <div class="mb-5">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Singkat (Maks. 100 karakter)
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror" 
                    placeholder="Contoh: Apa rumus volume tabung?"
                    required
                    maxlength="100"
                    value="{{ old('title') }}"
                >
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Detail Pertanyaan Anda
                </label>
                <textarea 
                    id="content" 
                    name="content" 
                    rows="6" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('content') border-red-500 @enderror" 
                    placeholder="Jelaskan secara rinci apa yang ingin Anda tanyakan..."
                    required
                >{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="topic_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Topik Mata Pelajaran
                </label>
                <select 
                    id="topic_id" 
                    name="topic_id" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('topic_id') border-red-500 @enderror"
                    required
                >
                    <option value="" disabled selected>-- Pilih Salah Satu Topik --</option>
                    {{-- Simulasi Looping Data Topik dari Database/Controller --}}
                    @php
                        $topics = [1 => 'Matematika', 2 => 'Biologi', 3 => 'Sejarah', 4 => 'Bahasa Inggris'];
                    @endphp
                    @foreach($topics as $id => $name)
                        <option value="{{ $id }}" {{ old('topic_id') == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('topic_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                Kirim Pertanyaan
            </button>
        </form>

    </div>
</main>

@endsection