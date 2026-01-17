<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Topik | KRFSM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <style>
        .swiper-container {
            max-width: 600px;
            margin: auto;
        }
    </style>
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

<!-- Content -->
<div class="max-w-6xl mx-auto mt-10 px-6">

    <!-- Search -->
    <div class="flex justify-center mb-8">
        <input 
            type="text" 
            placeholder="Search"
            class="w-80 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        >
    </div>

    <!-- Pilih Kategori -->
    <div class="flex flex-wrap gap-2 justify-center mb-4">
        @foreach($kategoris as $kategori)
            <button class="px-4 py-2 border border-blue-500 text-blue-500 rounded hover:bg-blue-500 hover:text-white">{{ $kategori }}</button>
        @endforeach
      </div>
    <script>
        const swiper = new Swiper('.swiper-container', {
          slidesPerView: 3,
          spaceBetween: 10,
          navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
          },
        });
    </script>

    <!-- Card Tutor -->
    <h2 class="text-xl font-semibold mb-6">Video Pengerjaan Soal Populer</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($videos as $video)
        <div class="bg-white rounded-xl shadow p-4">

            <div class="aspect-video mb-3">
              <iframe
                  class="w-full h-full rounded-lg"
                  src="https://www.youtube.com/embed/{{ $video['youtube_id'] }}"
                  frameborder="0"
                  allowfullscreen>
              </iframe>
            </div>
            
            <h3 class="font-semibold">{{ $video['title'] }}</h3>
            <span class="text-sm text-blue-500">{{ $video['mapel'] }}</span>
        </div>
        @endforeach
    </div>

</div>

<!-- Footer -->
<footer class="text-center text-sm text-gray-500 mt-16 mb-6">
    © 2025 <span class="text-blue-500 font-semibold">KRFSM</span>. 
    Dibuat dengan ❤️ menggunakan Laravel 10 & Tailwind CSS.
</footer>

</body>
</html>
