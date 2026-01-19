<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pertanyaan - Admin KRFSM</title>
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
                <a href="{{ route('admin.questions') }}" class="block px-4 py-2 rounded-lg bg-blue-700 hover:bg-blue-500 transition font-semibold">
                    ❓ Pertanyaan
                </a>
                <a href="{{ route('admin.topics') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-700 transition">
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
                    <h2 class="text-2xl font-bold text-gray-800">Kelola Pertanyaan</h2>
                    <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 font-semibold">← Kembali</a>
                </div>
            </div>

            <!-- Content -->
            <div class="max-w-7xl mx-auto p-8">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-600 text-green-700 p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Questions Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">Daftar Pertanyaan ({{ $questions->total() }})</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Penanya</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Jawaban</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Dibuat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($questions as $question)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <a href="{{ route('questions.show', $question->id) }}" class="text-blue-600 hover:text-blue-800 font-medium line-clamp-2">
                                                {{ $question->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600 text-xs">
                                                    {{ substr($question->user->name ?? 'U', 0, 1) }}
                                                </div>
                                                <span class="text-sm text-gray-800">{{ $question->user->name ?? 'Unknown' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <span class="inline-block px-2 py-1 bg-gray-100 rounded">
                                                {{ $question->answers_count ?? 0 }} jawaban
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $question->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                            <a href="{{ route('questions.show', $question->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                                Lihat
                                            </a>
                                            <form action="{{ route('admin.delete-question', $question->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin hapus pertanyaan ini?')" 
                                                    class="text-red-600 hover:text-red-800 font-semibold">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                            Belum ada pertanyaan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($questions->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 flex justify-center">
                            {{ $questions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
