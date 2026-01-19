<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Topik Baru - Admin KRFSM</title>
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
                    <h2 class="text-2xl font-bold text-gray-800">Buat Topik Baru</h2>
                    <a href="{{ route('admin.topics') }}" class="text-blue-600 hover:text-blue-800 font-semibold">← Kembali</a>
                </div>
            </div>

            <!-- Content -->
            <div class="max-w-3xl mx-auto p-8">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <form action="{{ route('admin.store-topic') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-800 mb-2">Nama Topik</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('name') border-red-500 @enderror"
                                placeholder="Contoh: Matematika, Fisika, dll">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug Field -->
                        <div>
                            <label for="slug" class="block text-sm font-semibold text-gray-800 mb-2">Slug (URL Friendly)</label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('slug') border-red-500 @enderror"
                                placeholder="Contoh: matematika, fisika, dll">
                            <p class="mt-1 text-xs text-gray-500">Gunakan huruf kecil dan strip (-) untuk spasi</p>
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-800 mb-2">Deskripsi</label>
                            <textarea id="description" name="description" rows="5" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('description') border-red-500 @enderror"
                                placeholder="Deskripsi lengkap tentang topik ini...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex space-x-4 pt-4 border-t border-gray-200">
                            <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition">
                                💾 Simpan Topik
                            </button>
                            <a href="{{ route('admin.topics') }}" class="flex-1 px-6 py-3 bg-gray-400 text-white rounded-lg hover:bg-gray-500 font-semibold transition text-center">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Info Box -->
                <div class="mt-8 bg-blue-50 border-l-4 border-blue-600 p-4 rounded">
                    <h4 class="font-semibold text-blue-900 mb-2">📝 Tips Membuat Topik</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>✓ Gunakan nama topik yang jelas dan deskriptif</li>
                        <li>✓ Slug harus unik dan tidak mengandung spasi</li>
                        <li>✓ Deskripsi membantu pengguna memahami topik</li>
                        <li>✓ Slug akan digunakan di URL topik</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
