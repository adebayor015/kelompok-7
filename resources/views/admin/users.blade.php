<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Admin KRFSM</title>
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
                <a href="{{ route('admin.users') }}" class="block px-4 py-2 rounded-lg bg-blue-700 hover:bg-blue-500 transition font-semibold">
                    👥 Pengguna
                </a>
                <a href="{{ route('admin.questions') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-700 transition">
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
                    <h2 class="text-2xl font-bold text-gray-800">Kelola Pengguna</h2>
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

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-600 text-red-700 p-4 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Users Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">Daftar Pengguna ({{ $users->total() }})</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Bergabung</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full 
                                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $user->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                            @if($user->role !== 'admin')
                                                <form action="{{ route('admin.delete-user', $user->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Yakin hapus pengguna ini?')" 
                                                        class="text-red-600 hover:text-red-800 font-semibold">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs">Admin (tidak bisa dihapus)</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                            Belum ada pengguna
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($users->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 flex justify-center">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
