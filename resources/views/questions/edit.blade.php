@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Edit Pertanyaan</h1>
            <p class="mt-2 text-gray-600">Perbarui pertanyaanmu agar lebih jelas dan mudah dijawab orang lain.</p>
        </div>

        <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
            <form action="{{ route('questions.update', $question->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Pertanyaan</label>
                    <input type="text" name="title" id="title" 
                        value="{{ old('title', $question->title) }}" 
                        required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all @error('title') border-red-500 @enderror"
                        placeholder="Contoh: Bagaimana cara install Laravel?">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="topic_id" class="block text-sm font-semibold text-gray-700 mb-2">Topik Terkait</label>
                    <div class="relative">
                        <select name="topic_id" id="topic_id" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none appearance-none transition-all">
                            @foreach($topics as $topic)
                                <option value="{{ $topic->id }}" {{ $topic->id == old('topic_id', $question->topic_id) ? 'selected' : '' }}>
                                    {{ $topic->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Isi Detail Pertanyaan</label>
                    <textarea name="content" id="content" rows="8" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all @error('content') border-red-500 @enderror"
                        placeholder="Jelaskan secara mendalam... Kalau bisa kasih contoh kodenya sekalian.">{{ old('content', $question->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                        Batal
                    </a>
                    <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-bold shadow-lg shadow-blue-200 transition-all active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection