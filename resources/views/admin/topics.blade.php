<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Topik - Admin KRFSM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white shadow-lg">
            <div class="p-6 border-b border-blue-700">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/krfsmrp.png') }}" alt="KRFSM" class="h-10">
                    <h1 class="font-bold text-lg">KRFSM Admin</h1>
                </div>
            </div>

            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    📊 Dashboard
                </a>
                <a href="{{ route('admin.users') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    👥 Pengguna
                </a>
                <a href="{{ route('admin.questions') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    ❓ Pertanyaan
                </a>
                <a href="{{ route('admin.topics') }}" class="block px-4 py-2 rounded-lg bg-blue-700 hover:bg-blue-500 transition font-semibold">
                    📚 Topik
                </a>
            </nav>

            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-blue-700 w-64">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-3 py-2 bg-red-600 hover:bg-red-700 rounded-lg text-sm font-semibold transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Top Bar -->
            <div class="bg-white shadow-md sticky top-0 z-40">
                <div class="max-w-7xl mx-auto px-8 py-4 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">Kelola Topik</h2>
                    <a href="{{ route('admin.create-topic') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 font-semibold">+ Tambah Topik</a>
                </div>
            </div>

            <!-- Content -->
            <div class="max-w-7xl mx-auto p-8">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-600 text-green-700 p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Topics Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($topics as $topic)
                        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $topic->name }}</h3>
                            <p class="text-sm text-gray-600 mb-4 line-clamp-3">{{ $topic->description }}</p>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <span class="text-xs text-gray-500">
                                    Slug: <code class="bg-gray-100 px-2 py-1 rounded">{{ $topic->slug }}</code>
                                </span>
                            </div>

                            <div class="mt-4 flex space-x-2">
                                <a href="{{ route('topik.show', $topic->slug) }}" class="flex-1 text-center px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold text-sm transition">
                                    Lihat
                                </a>
                                <form action="{{ route('admin.delete-topic', $topic->id) }}" method="POST" style="display:inline;" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin hapus topik ini?')" 
                                        class="w-full px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold text-sm transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500 text-lg">Belum ada topik</p>
                            <a href="{{ route('admin.create-topic') }}" class="mt-4 inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 font-semibold">
                                Buat Topik Pertama
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($topics->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $topics->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
