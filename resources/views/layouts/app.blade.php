<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KRFSM | @yield('title', 'Forum Tanya Jawab')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- Panggil navbar di sini --}}
    <x-navbar>
        <a href="/" class="hover:text-blue-600 {{ request()->is('/') ? 'font-bold text-blue-600' : '' }}">Beranda</a>
        <a href="/topik" class="hover:text-blue-600 {{ request()->is('topik*') ? 'font-bold text-blue-600' : '' }}">Topik</a>
        <a href="#" class="hover:text-blue-600">Ranking</a>
        <a href="#" class="hover:text-blue-600">Profile</a>
        <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Masuk</a>
    </x-navbar>
    
    <div class="container mx-auto mt-8 px-4">
        @yield('content')
    </div>

</body>