<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KRFSM – Forum Tanya Jawab Pelajar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="KRFSM Logo" class="h-8">
                <span class="font-semibold text-xl text-blue-600">KRFSM</span>
            </div>
            <div class="hidden md:flex space-x-6 text-sm font-medium">
                <a href="#" class="hover:text-blue-600">Beranda</a>
                <a href="#" class="hover:text-blue-600">Topik</a>
                <a href="#" class="hover:text-blue-600">Ranking</a>
                <a href="#" class="hover:text-blue-600">Masuk</a>
            </div>
        </div>
    </nav>

    <!-- Hero / Search Section -->
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

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-10 grid md:grid-cols-3 gap-6">
        <!-- Question Feed -->
        <div class="md:col-span-2 space-y-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Pertanyaan Terbaru</h2>

            <!-- Contoh Card Pertanyaan -->
            @foreach ([
                ['name' => 'Rina', 'question' => 'Apa perbedaan antara fotosintesis dan respirasi tumbuhan?', 'answers' => 4],
                ['name' => 'Budi', 'question' => 'Jelaskan pengaruh revolusi industri terhadap kehidupan manusia modern.', 'answers' => 2],
                ['name' => 'Sinta', 'question' => 'Apa fungsi utama dari sistem operasi komputer?', 'answers' => 5],
            ] as $item)
            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-700 font-medium mb-2">{{ $item['question'] }}</p>
                        <p class="text-sm text-gray-500">Ditanyakan oleh <span class="font-semibold text-gray-700">{{ $item['name'] }}</span></p>
                    </div>
                    <span class="bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full">{{ $item['answers'] }} Jawaban</span>
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button class="text-sm text-blue-600 hover:underline">Lihat Jawaban</button>
                    <button class="text-sm text-gray-600 hover:underline">Jawab</button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Sidebar -->
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
                <button class="bg-white text-blue-700 font-semibold px-4 py-2 rounded-full hover:bg-blue-50">Tanya Sekarang</button>
            </div>
        </aside>
    </main>

    <!-- Footer -->
    <footer class="bg-white text-center text-sm py-6 text-gray-500 border-t">
        © 2025 <span class="font-semibold text-blue-600">KRFSM</span>. Dibuat dengan ❤️ menggunakan Laravel 10 & Tailwind CSS.
    </footer>
</body>
</html>
