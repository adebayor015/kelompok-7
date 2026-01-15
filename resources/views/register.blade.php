<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar – KRFSM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen">

<div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">
        Daftar Akun KRFSM
    </h2>

    {{-- ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.proses') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium">Nama</label>
            <input type="text" name="name" class="w-full px-4 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" class="w-full px-4 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Password</label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded" required>
        </div>

        <div class="mb-5">
            <label class="block text-sm font-medium">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded" required>
        </div>

        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Daftar
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-4">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
            Login
        </a>
    </p>
</div>

</body>
</html>
