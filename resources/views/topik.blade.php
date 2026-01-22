<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topik | KRFSM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <nav class="bg-white shadow-md sticky top-0 z-10">
      <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
          <div class="flex items-center space-x-2">
              <a href="/" class="font-semibold text-xl text-blue-600">KRFSM</a>
          </div>
          <div class="hidden md:flex space-x-6 text-sm font-medium">
              <a href="/" class="hover:text-blue-600 transition">Beranda</a>
              <a href="/topik" class="text-blue-600 transition">Topik</a>
          </div>
      </div>
    </nav>

    <div class="max-w-6xl mx-auto mt-10 px-6">
        
        <div class="flex flex-wrap gap-2 justify-center mb-10">
            @foreach($kategoris as $kategori)
                <a href="{{ route('topik.show', $kategori->slug) }}"
                   class="px-5 py-2 border border-blue-500 text-blue-500 rounded-full font-medium hover:bg-blue-500 hover:text-white transition-all duration-300 shadow-sm">
                   {{ $kategori->name }}
                </a>
            @endforeach
        </div>

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Video Pengerjaan Soal Populer</h2>
            <div class="h-1 flex-grow ml-4 bg-gradient-to-r from-blue-500 to-transparent rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($videos as $video)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
                <div class="aspect-video relative overflow-hidden bg-black">
                    <iframe
                        class="absolute inset-0 w-full h-full"
                        src="{{ $video->video_url }}" 
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen>
                    </iframe>
                </div>

                <div class="p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-xs font-bold rounded uppercase tracking-wide">
                            {{ $video->topic->name ?? 'Materi' }}
                        </span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-800 mb-2 leading-tight group-hover:text-blue-600 transition-colors">
                        {{ $video->title }}
                    </h3>
                    <p class="text-gray-500 text-sm line-clamp-2">
                        Pelajari langkah-langkah penyelesaian soal materi {{ $video->topic->name ?? '' }} secara lengkap di video ini.
                    </p>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-blue-50 border-2 border-dashed border-blue-200 rounded-3xl p-12 text-center">
                <p class="text-blue-500 font-medium">Belum ada video materi yang tersedia saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>

    <footer class="text-center text-sm text-gray-400 mt-20 mb-8 py-6 border-t border-gray-200">
        <p>© 2026 <span class="text-blue-500 font-semibold uppercase">Krfsm Learning</span>. Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>