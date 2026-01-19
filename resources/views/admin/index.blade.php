<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - KRFSM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar { transition: transform 0.3s ease; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white shadow-lg">
            <div class="p-6 border-b border-blue-700">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/krfsmrp.png') }}" alt="KRFSM" class="h-10">
                    <div>
                        <h1 class="font-bold text-xl">KRFSM</h1>
                        <p class="text-xs text-blue-200">Admin Panel</p>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.index') }}" class="block px-4 py-2 rounded-lg bg-blue-700 hover:bg-blue-500 transition font-semibold">
                    📊 Dashboard
                </a>
                <a href="{{ route('admin.users') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    👥 Pengguna
                </a>
                <a href="{{ route('admin.questions') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    ❓ Pertanyaan
                </a>
                <a href="{{ route('admin.topics') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    📚 Topik
                </a>
                <a href="{{ route('admin.settings') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    ⚙️ Pengaturan
                </a>
            </nav>

            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-blue-700 w-64">
                <div class="flex items-center space-x-2 mb-3">
                    <div class="w-10 h-10 rounded-full bg-blue-400 flex items-center justify-center font-bold">
                        {{ substr(session('user_name'), 0, 1) }}
                    </div>
                    <div class="text-sm">
                        <p class="font-semibold">{{ session('user_name') }}</p>
                        <p class="text-xs text-blue-200">Administrator</p>
                    </div>
                </div>
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
                    <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
                    <div class="flex items-center space-x-4">
                        <div class="text-right text-sm">
                            <p class="text-gray-600">{{ now()->format('d M Y') }}</p>
                            <p class="font-semibold text-gray-800">{{ now()->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="max-w-7xl mx-auto p-8">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Users -->
                    <div class="card-hover bg-white rounded-lg shadow p-6 border-l-4 border-blue-600">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-sm font-semibold">Total Pengguna</p>
                                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $total_users ?? 0 }}</p>
                                <p class="text-xs text-gray-400 mt-2">Pengguna terdaftar</p>
                            </div>
                            <div class="text-4xl text-blue-600 opacity-20">👥</div>
                        </div>
                    </div>

                    <!-- Total Questions -->
                    <div class="card-hover bg-white rounded-lg shadow p-6 border-l-4 border-green-600">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-sm font-semibold">Total Pertanyaan</p>
                                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $total_questions ?? 0 }}</p>
                                <p class="text-xs text-gray-400 mt-2">Pertanyaan aktif</p>
                            </div>
                            <div class="text-4xl text-green-600 opacity-20">❓</div>
                        </div>
                    </div>

                    <!-- Total Answers -->
                    <div class="card-hover bg-white rounded-lg shadow p-6 border-l-4 border-purple-600">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-sm font-semibold">Total Jawaban</p>
                                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $total_answers ?? 0 }}</p>
                                <p class="text-xs text-gray-400 mt-2">Jawaban diberikan</p>
                            </div>
                            <div class="text-4xl text-purple-600 opacity-20">💬</div>
                        </div>
                    </div>

                    <!-- Total Topics -->
                    <div class="card-hover bg-white rounded-lg shadow p-6 border-l-4 border-orange-600">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-sm font-semibold">Total Topik</p>
                                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $total_topics ?? 0 }}</p>
                                <p class="text-xs text-gray-400 mt-2">Kategori topik</p>
                            </div>
                            <div class="text-4xl text-orange-600 opacity-20">📚</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity & Quick Actions -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Recent Users -->
                    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Pengguna Terbaru</h3>
                        <div class="space-y-3">
                            @if(isset($recent_users) && count($recent_users) > 0)
                                @foreach($recent_users as $user)
                                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600">
                                                {{ substr($user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $user->name ?? 'User' }}</p>
                                                <p class="text-xs text-gray-500">{{ $user->email ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-400">{{ $user->created_at?->diffForHumans() ?? '-' }}</span>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500 text-center py-4">Belum ada data pengguna</p>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin.users') }}" class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center font-semibold">
                                👥 Kelola Pengguna
                            </a>
                            <a href="{{ route('admin.questions') }}" class="block w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-center font-semibold">
                                ❓ Kelola Pertanyaan
                            </a>
                            <a href="{{ route('admin.topics') }}" class="block w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-center font-semibold">
                                📚 Kelola Topik
                            </a>
                            <a href="{{ route('home') }}" class="block w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-center font-semibold">
                                🏠 Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System Information -->
                <div class="mt-8 bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Sistem</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="border-l-4 border-gray-300 pl-4">
                            <p class="text-gray-500">Versi Laravel</p>
                            <p class="font-semibold text-gray-800">Laravel 11</p>
                        </div>
                        <div class="border-l-4 border-gray-300 pl-4">
                            <p class="text-gray-500">Database</p>
                            <p class="font-semibold text-gray-800">MySQL</p>
                        </div>
                        <div class="border-l-4 border-gray-300 pl-4">
                            <p class="text-gray-500">Waktu Server</p>
                            <p class="font-semibold text-gray-800">{{ now()->timezone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
