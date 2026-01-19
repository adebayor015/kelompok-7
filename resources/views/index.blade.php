<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KRFSM – Forum Tanya Jawab Pelajar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Smooth transition untuk hover card */
        .question-card { transition: all 0.3s ease; }
        .question-card:hover { transform: translateY(-3px); }
        
        /* Animasi halus untuk gambar */
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/krfsmrp.png') }}" alt="KRFSM Logo" class="h-16">
                <span class="font-bold text-2xl text-blue-600 tracking-tight">KRFSM</span>
            </div>
            <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="text-blue-600 border-b-2 border-blue-600 pb-1">Beranda</a>
                <a href="{{ route('topik') }}" class="text-gray-600 hover:text-blue-600 transition">Topik</a>
                <a href="#" class="text-gray-600 hover:text-blue-600 transition">Ranking</a>
                <a href="{{ route('profile') }}" class="text-gray-600 hover:text-blue-600 transition">Profile</a>
                
                @if(session('logged_in'))
                    @if(session('user_role') === 'admin')
                        <a href="{{ route('admin.index') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-bold hover:bg-yellow-600 transition">🔧 Admin Panel</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-50 text-red-600 px-4 py-2 rounded-lg font-bold hover:bg-red-100 transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">Masuk</a>
                @endif
            </div>
        </div>
        
        @if(session('success'))
            <div id="alert-success" class="bg-green-100 border-b border-green-400 text-green-700 px-4 py-3 text-center text-sm">
                <strong class="font-bold">Sukses!</strong> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div id="alert-error" class="bg-red-100 border-b border-red-400 text-red-700 px-4 py-3 text-center text-sm">
                <strong class="font-bold">Gagal!</strong> {{ session('error') }}
            </div>
        @endif
        <script>
            setTimeout(() => {
                const alerts = document.querySelectorAll('#alert-success, #alert-error');
                alerts.forEach(el => el.style.display = 'none');
            }, 3000);
        </script>
    </nav>

    <section class="bg-blue-50 py-12 border-b border-blue-100 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-12 gap-8 items-center">
            
            <div class="md:col-span-6 lg:col-span-5">
                <h1 class="text-4xl md:text-5xl font-extrabold text-blue-900 mb-6 leading-tight">
                    Temukan Jawaban <br><span class="text-blue-600">Terbaik</span> di KRFSM!
                </h1>
                <p class="text-gray-600 mb-8 text-lg leading-relaxed">
                    Forum pelajar untuk bertanya, berdiskusi, dan belajar bersama. Temukan solusi untuk tugas sekolahmu hari ini.
                </p>
                <div class="flex items-center bg-white rounded-full shadow-xl overflow-hidden border border-blue-200 p-1.5 focus-within:ring-2 focus-within:ring-blue-400 transition">
                    <input type="text" placeholder="Apa yang ingin kamu tanyakan hari ini?" class="flex-grow px-6 py-3 text-sm focus:outline-none text-gray-700">
                    <button class="bg-blue-600 text-white px-8 py-3 rounded-full text-sm font-bold hover:bg-blue-700 transition shadow-md">Cari</button>
                </div>
                <div class="mt-4 text-xs text-gray-400 flex space-x-3 items-center">
                    <span>Populer saat ini:</span>
                    <a href="#" class="text-blue-500 hover:underline">#Matematika</a>
                    <a href="#" class="text-blue-500 hover:underline">#Fisika</a>
                    <a href="#" class="text-blue-500 hover:underline">#UjianNasional</a>
                </div>
            </div>
            
            <div class="hidden md:flex md:col-span-6 lg:col-span-7 justify-end items-center">
                <img src="{{ asset('images/krfsmrp.png') }}" 
                     alt="Ilustrasi KRFSM" 
                     class="h-[450px] w-auto object-contain drop-shadow-2xl animate-float">
            </div>

        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 py-12 grid md:grid-cols-3 gap-8">

        <div class="md:col-span-2 space-y-8">
            <div class="flex justify-between items-center border-b pb-4 border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Pertanyaan Terbaru</h2>
                <span class="text-sm text-blue-600 font-medium">Total: {{ isset($questions) ? count($questions) : 0 }} Diskusi</span>
            </div>

            @if(isset($questions) && count($questions) > 0)
                @foreach ($questions as $question)
                <div class="question-card bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-blue-200 transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-xs font-bold bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg uppercase tracking-wider">
                            {{ $question->topic->name ?? 'Umum' }}
                        </span>
                        <span class="text-xs text-gray-400 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path></svg>
                            {{ $question->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 hover:text-blue-600 transition mb-3">
                        <a href="{{ route('questions.show', $question->id) }}">
                            {{ $question->title }}
                        </a>
                    </h3>

                    <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-50">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-blue-300 flex items-center justify-center text-white text-sm font-bold shadow-inner">
                                {{ strtoupper(substr($question->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Ditanyakan oleh</p>
                                <p class="text-sm font-bold text-gray-700 leading-none">{{ $question->user->name }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-6 text-gray-400 font-semibold text-sm">
                            <span class="flex items-center hover:text-blue-500 transition">
                                <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                {{ $question->answers->count() }}
                            </span>
                            <span class="flex items-center hover:text-red-500 transition">
                                <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                {{ $question->likes_count ?? 0 }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="bg-white p-16 rounded-2xl shadow-sm text-center border-2 border-dashed border-gray-200">
                    <img src="https://illustrations.popsy.co/blue/creative-work.svg" class="h-40 mx-auto mb-6 opacity-70">
                    <p class="text-gray-500 text-lg">Belum ada pertanyaan terbaru. <br>Yuk, jadilah yang pertama bertanya!</p>
                </div>
            @endif
        </div>

        <aside class="space-y-8">
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white p-8 rounded-2xl shadow-xl relative overflow-hidden group">
                <div class="relative z-10 text-center">
                    <h3 class="text-xl font-bold mb-3">Punya Pertanyaan Sulit?</h3>
                    <p class="text-blue-100 text-sm mb-6">Jangan dipendam sendiri, tanyakan pada komunitas KRFSM!</p>
                    <a href="{{ route('questions.create') }}" class="inline-block w-full bg-white text-blue-700 font-bold px-6 py-3 rounded-xl hover:bg-blue-50 transition shadow-lg text-center">Tanya Sekarang</a>
                </div>
                <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-white opacity-10 rounded-full group-hover:scale-110 transition duration-500"></div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-800 text-lg">Top Kontributor 🏆</h3>
                    <a href="#" class="text-xs text-blue-500 font-bold hover:underline">LIHAT SEMUA</a>
                </div>
                <div class="space-y-5">
                    <div class="flex items-center space-x-4">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" class="w-10 h-10 rounded-full bg-blue-50 border border-gray-100">
                        <div class="flex-grow">
                            <p class="text-sm font-bold text-gray-700">Ahmad Zaki</p>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">120 Jawaban</p>
                        </div>
                        <span class="bg-yellow-100 text-yellow-700 text-[10px] font-extrabold px-2 py-1 rounded">#1</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Aneka" class="w-10 h-10 rounded-full bg-pink-50 border border-gray-100">
                        <div class="flex-grow">
                            <p class="text-sm font-bold text-gray-700">Sarah Wijaya</p>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">85 Jawaban</p>
                        </div>
                        <span class="bg-gray-100 text-gray-500 text-[10px] font-extrabold px-2 py-1 rounded">#2</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 text-lg mb-4">Topik Populer</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('topik.show', 'matematika') }}" class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-600 hover:text-white transition">Matematika</a>
                    <a href="{{ route('topik.show', 'bahasa-inggris') }}" class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-600 hover:text-white transition">B. Inggris</a>
                    <a href="{{ route('topik.show', 'biologi') }}" class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-600 hover:text-white transition">Biologi</a>
                    <a href="{{ route('topik.show', 'sejarah') }}" class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-600 hover:text-white transition">Sejarah</a>
                </div>
            </div>
        </aside>

    </main>

    <footer class="bg-white text-center py-10 text-sm text-gray-400 border-t border-gray-100">
        <div class="mb-2">
            <span class="font-bold text-blue-600">KRFSM</span> — Komunitas Ruang Belajar Pintar
        </div>
        <p>© 2025 All Rights Reserved. Dibuat dengan ❤️ menggunakan Laravel 10 & Tailwind CSS.</p>
    </footer>

</body>
</html> 