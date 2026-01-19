@extends('layouts.app')

@section('title','Cari Pengguna')

@section('content')
<main class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Cari Pengguna</h1>
        <form method="GET" action="{{ route('users.index') }}" class="mb-4">
            <input type="text" name="q" value="{{ old('q', $query) }}" placeholder="Cari nama atau email..." class="w-full p-3 border rounded" />
        </form>

        @if($users->count())
            <ul class="space-y-4">
                @foreach($users as $u)
                    <li class="p-4 border rounded flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            @if($u->avatar)
                                <img src="{{ asset('storage/'.$u->avatar) }}" alt="avatar" class="w-14 h-14 rounded-full object-cover">
                            @else
                                <div class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center">{{ strtoupper(substr($u->name,0,1)) }}</div>
                            @endif
                            <div>
                                <a href="{{ route('users.show',$u->id) }}" class="font-semibold text-blue-600">{{ $u->name }}</a>
                                <div class="text-sm text-gray-600">{{ Str::limit($u->bio, 80) }}</div>
                            </div>
                        </div>
                        <div>
                            @if($me && $me->id !== $u->id)
                                @php $isFollowing = $me->isFollowing($u); @endphp
                                <form action="{{ $isFollowing ? route('users.unfollow',$u->id) : route('users.follow',$u->id) }}" method="POST">
                                    @csrf
                                    <button class="px-3 py-2 rounded {{ $isFollowing ? 'bg-gray-200' : 'bg-blue-600 text-white' }}">{{ $isFollowing ? 'Unfollow' : 'Follow' }}</button>
                                </form>
                            @else
                                <a href="{{ route('users.show',$u->id) }}" class="px-3 py-2 rounded bg-gray-100">Lihat</a>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">{{ $users->links() }}</div>
        @else
            <div class="text-gray-600">Tidak ada pengguna ditemukan.</div>
        @endif
    </div>
</main>
@endsection
