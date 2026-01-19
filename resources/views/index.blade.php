<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KRFSM – Forum Tanya Jawab Pelajar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <nav class="bg-white shadow-md sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/krfsmrp.png') }}" alt="KRFSM Logo" class="h-20">
                <span class="font-semibold text-xl text-blue-600">KRFSM</span>
            </div>
            <div class="hidden md:flex space-x-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <a href="{{ route('topik') }}" class="hover:text-blue-600">Topik</a>
                <a href="#" class="hover:text-blue-600">Ranking</a>
                <a href="{{ route('profile') }}" class="hover:text-blue-600">Profile</a>
                @if(session('logged_in'))
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                    <button type="submit" class="text-red-600 font-bold hover:underline">
                    Logout
                    </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-blue-600">Masuk</a>
                @endif

                @if(session('success'))
                        <div class="max-w-7xl mx-auto mt-4 px-4">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        <strong class="font-bold">Sukses!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <script>
                            setTimeout(() => {
                            document.querySelectorAll('[class*="bg-green-100"], [class*="bg-red-100"]')
                            .forEach(el => el.remove());
                             }, 3000);
                        </script>

                    </div>
                </div>
                @endif

                @if(session('error'))
                        <div class="max-w-7xl mx-auto mt-4 px-4">
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <strong class="font-bold">Gagal!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <script>
                            setTimeout(() => {
                            document.querySelectorAll('[class*="bg-green-100"], [class*="bg-red-100"]')
                            .forEach(el => el.remove());
                             }, 3000);
                        </script>
                    </div>
                </div>
                @endif  

            </div>
        </div>
    </nav>

    <section class="bg-blue-50 py-12">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-blue-700 mb-4">Temukan Jawaban Terbaik di KRFSM!</h1>
            <p class="text-gray-600 mb-6">Forum pelajar untuk bertanya, berdiskusi, dan belajar bersama.</p>
            <div class="flex items-center bg-white rounded-full shadow-md overflow-hidden">
                <input type="text" placeholder="Apa yang ingin kamu tanyakan hari ini?" class="flex-grow px-4 py-3 text-sm focus:outline-none">
                <button class="bg-blue-600 text-white px-6 py-3 text-sm font-semibold hover:bg-blue-700">Cari</button>
            </div>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 py-10 grid md:grid-cols-3 gap-6">

        <div class="md:col-span-2 space-y-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Pertanyaan Terbaru</h2>

            {{-- Cek apakah variabel $questions ada dan tidak kosong (Dikirim dari QuestionController@index) --}}
            @if(isset($questions) && count($questions) > 0)

                @foreach ($questions as $question)

<div class="question-card bg-white p-6 rounded-xl shadow-md border border-gray-200">
    <div class="flex justify-between items-start mb-3">
        <span class="text-xs font-medium bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
            {{ $question->topic->name ?? 'Umum' }}
        </span>
        <span class="text-xs text-gray-500">
            {{ $question->created_at->diffForHumans() }}
        </span>
    </div>

    <h3 class="text-lg font-bold text-gray-800 hover:text-blue-600 transition">
        <a href="{{ route('questions.show', $question->id) }}">
            {{ $question->title }}
        </a>
    </h3>

    <p class="text-sm text-gray-500 mt-2">
        Ditanyakan oleh
        <span class="font-medium text-blue-600">
            {{ $question->user->name }}
        </span>
    </p>

    <div class="flex items-center space-x-4 text-gray-500 text-sm mt-4 pt-3 border-t">
        <span>{{ $question->answers->count() }} Jawaban</span>
        <span>{{ $question->likes_count ?? 0 }} Suka</span>
    </div>
</div>

@endforeach

            @else
                <div class="bg-white p-6 rounded-xl shadow-md text-center text-gray-500">
                    Belum ada pertanyaan terbaru. Yuk, mulai bertanya!
                </div>
            @endif
        </div>

        <aside class="space-y-6">
            <div class="bg-white p-5 rounded-xl shadow-sm">
                <h3 class="font-semibold text-gray-700 mb-3">Topik Populer</h3>
                <ul class="space-y-2 text-sm">
                    <div class="bg-white p-5 rounded-xl shadow-sm">
    <h3 class="font-semibold text-gray-700 mb-3">Topik Populer</h3>
    <ul class="space-y-2 text-sm">
        <li>
            <a href="{{ route('topik.show', 'matematika') }}"
               class="text-blue-600 hover:underline">
               Matematika
            </a>
        </li>
        <li>
            <a href="{{ route('topik.show', 'bahasa-inggris') }}"
               class="text-blue-600 hover:underline">
               Bahasa Inggris
            </a>
        </li>
        <li>
            <a href="{{ route('topik.show', 'biologi') }}"
               class="text-blue-600 hover:underline">
               Biologi
            </a>
        </li>
        <li>
            <a href="{{ route('topik.show', 'sejarah') }}"
               class="text-blue-600 hover:underline">
               Sejarah
            </a>
        </li>
    </ul>
</div>

                </ul>
            </div>
            <div class="bg-blue-600 text-white p-5 rounded-xl text-center shadow-md">
                <h3 class="text-lg font-semibold mb-2">Ingin Bertanya?</h3>
                <p class="text-sm mb-4">Klik tombol di bawah untuk membuat pertanyaan baru di KRFSM.</p>
                <a href="{{ route('questions.create') }}" class="bg-white text-blue-700 font-semibold px-4 py-2 rounded-full hover:bg-blue-50">Tanya Sekarang</a>
            </div>
        </aside>

    </main>

    <footer class="bg-white text-center text-sm py-6 text-gray-500 border-t">
        © 2025 <span class="font-semibold text-blue-600">KRFSM</span>. Dibuat dengan ❤️ menggunakan Laravel 10 & Tailwind CSS.
    </footer>

</body>
</html>