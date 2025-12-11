{{-- File: resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KRFSM | @yield('title', 'Forum Tanya Jawab')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Di sini bisa ditambahkan link CSS lain --}}
</head>
<body class="bg-gray-100 text-gray-800">
    {{-- Navbar bisa ditaruh di sini, atau sebagai @include('layouts.navbar') --}}
    
    <div class="container mx-auto">
        @yield('content') {{-- Ini tempat konten show.blade.php akan dimasukkan --}}
    </div>

    {{-- Footer bisa ditaruh di sini --}}
</body>
</html>