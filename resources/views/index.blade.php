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
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="KRFSM Logo" class="h-8">
                <span class="font-semibold text-xl text-blue-600">KRFSM</span>
            </div>
            <div class="hidden md:flex space-x-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <a href="{{ route('topik') }}" class="hover:text-blue-600">Topik</a>
                <a href="#" class="hover:text-blue-600">Ranking</a>
                <a href="{{ route('profile') }}" class="hover:text-blue-600">Profile</a>
                <a href="{{ route('login') }}" class="hover:text-blue-600">Masuk</a>
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
                
                @php
                    // Logika penentuan warna badge
                    $badgeColor = [
                        'blue' => 'bg-blue-100 text-blue-800',
                        'green' => 'bg-green-100 text-green-800',
                        'yellow' => 'bg-yellow-100 text-yellow-800',
                        'red' => 'bg-red-100 text-red-800',
                    ][$question['color'] ?? 'gray'] ?? 'bg-gray-100 text-gray-800';
                    
                    // Hitung jumlah jawaban
                    $answerCount = count($question['answers'] ?? []);
                @endphp

                <div class="question-card bg-white p-6 rounded-xl shadow-md border border-gray-200">
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-xs font-medium {{ $badgeColor }} px-3 py-1 rounded-full">{{ $question['topic'] ?? 'Umum' }}</span>
                        <span class="text-xs text-gray-500">{{ $question['time'] ?? 'Baru saja' }}</span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 hover:text-blue-600 transition duration-150">
                        {{-- Pastikan route('questions.show') sudah didefinisikan di web.php --}}
                        <a href="{{ route('questions.show', $question['id']) }}">
                            {{ $question['title'] }}
                        </a>
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">Ditanyakan oleh <a href="#" class="font-medium text-blue-600">{{ $question['user'] ?? 'Anonim' }}</a></p>
                    
                    <div class="flex items-center space-x-4 text-gray-500 text-sm mt-4 pt-3 border-t border-gray-100">
                        <span class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 4v-4z"></path></svg>
                            <span>{{ $answerCount }} Jawaban</span>
                        </span>
                        <span class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                            {{-- Angka Suka disimulasikan, bisa diganti dengan data $question['likes'] --}}
                            <span>7 Suka</span> 
                        </span>
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
                    <li><a href="#" class="text-blue-600 hover:underline">Matematika</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">Bahasa Inggris</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">Biologi</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">Sejarah</a></li>
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