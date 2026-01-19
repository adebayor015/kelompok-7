<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Notifikasi Jawaban</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-4xl mx-auto">
    <div class="bg-white p-6 rounded shadow">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold">Notifikasi Jawaban untuk pertanyaan Anda</h1>
                <p class="text-sm text-gray-500 mt-2">Di sini muncul jawaban dari pengguna lain untuk pertanyaan yang Anda ajukan.</p>
            </div>
            <div>
                <form action="{{ route('profile.notifications.mark_read') }}" method="POST" id="mark-read-form">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded shadow">Tandai sudah dibaca</button>
                </form>
            </div>
        </div>

        @if(isset($answers) && $answers->count())
            <ul class="mt-4 space-y-3">
                @foreach($answers as $a)
                    <li class="p-3 border rounded hover:bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div>
                                <a href="{{ route('questions.show', $a->question->id) }}" class="font-semibold text-blue-600">{{ $a->question->title }}</a>
                                <div class="text-sm text-gray-600 mt-1">Jawaban dari <strong>{{ $a->user->name }}</strong> — {{ $a->created_at->diffForHumans() }}</div>
                                <div class="mt-2 text-gray-700">{{ Str::limit($a->content, 220) }}</div>
                            </div>
                            <div class="text-xs text-gray-400 ml-4">Pertanyaan ID: {{ $a->question->id }}</div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">{{ $answers->links() }}</div>
        @else
            <div class="mt-4 text-gray-600">Belum ada jawaban untuk pertanyaan Anda.</div>
        @endif
    </div>
</div>
</body>
</html>