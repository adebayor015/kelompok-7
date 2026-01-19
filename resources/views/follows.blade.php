<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Follows' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
<div class="max-w-3xl mx-auto p-6">
    <a href="javascript:history.back()" class="text-blue-600">&larr; Back</a>
    <h1 class="text-2xl font-bold mt-4">{{ $title }}</h1>

    <div class="mt-6 bg-white p-4 rounded shadow">
        @if($users->count())
            <ul>
                @foreach($users as $u)
                    <li class="py-3 border-b last:border-b-0 flex items-center justify-between">
                        <div>
                            <div class="font-semibold">{{ $u->name }}</div>
                            <div class="text-sm text-gray-500">{{ $u->email }}</div>
                        </div>
                        <div>
                            <a href="{{ route('users.show', $u->id) }}" class="text-blue-600">View</a>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @else
            <div class="text-gray-600">No users to show.</div>
        @endif
    </div>
</div>
</body>
</html>
