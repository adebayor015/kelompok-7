<nav class="bg-white shadow-md sticky top-0 z-10">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                 alt="KRFSM Logo"
                 class="h-8">
            <span class="font-semibold text-xl text-blue-600">KRFSM</span>
        </div>

        <div class="hidden md:flex space-x-6 text-sm font-medium">
            {{ $slot }}
        </div>
    </div>
</nav>
