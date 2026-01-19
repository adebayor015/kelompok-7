@extends('layouts.app')

@section('title', 'Tanya Pertanyaan Baru')

@section('content')
<main class="max-w-3xl mx-auto px-4 py-10">
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">

        <h1 class="text-2xl font-bold text-blue-700 mb-6 border-b pb-4">
            🗣️ Ajukan Pertanyaan Baru
        </h1>

        <form action="{{ route('questions.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            {{-- JUDUL --}}
            <div class="mb-5">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Singkat (Maks. 100 karakter)
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    maxlength="100"
                    required
                    class="w-full p-3 border rounded-lg @error('title') border-red-500 @enderror"
                >
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- DETAIL --}}
            <div class="mb-5">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Detail Pertanyaan
                </label>
                <textarea
                    id="content"
                    name="content"
                    rows="5"
                    required
                    class="w-full p-3 border rounded-lg @error('content') border-red-500 @enderror"
                >{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ATTACHMENT --}}
            <div class="mb-5">
                <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2">
                    Lampiran (Opsional)
                </label>
                <input
                    type="file"
                    id="attachment"
                    name="attachment"
                    class="block w-full text-sm"
                >
                @error('attachment')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- TOPIK --}}
            <div class="mb-6">
                <label for="topic_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Topik Mata Pelajaran
                </label>
                <select
                    id="topic_id"
                    name="topic_id"
                    required
                    class="w-full p-3 border rounded-lg @error('topic_id') border-red-500 @enderror"
                >
                    <option value="">-- Pilih Topik --</option>
                    @foreach($topics as $topic)
                        <option value="{{ $topic->id }}">
                            {{ $topic->name }}
                        </option>
                    @endforeach
                </select>
                @error('topic_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- SUBMIT --}}
            <button type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
                Kirim Pertanyaan
            </button>

        </form>
    </div>
</main>
@endsection
