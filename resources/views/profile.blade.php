<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root{--card-bg:#fff;--muted:#6b7280}
        body{font-family:Inter,ui-sans-serif,system-ui,Segoe UI,Roboto,Helvetica,Arial;margin:0;background:#f3f4f6}
        .container{max-width:1000px;margin:36px auto;padding:20px}
        .card{background:var(--card-bg);border-radius:12px;box-shadow:0 6px 18px rgba(15,23,42,0.06);padding:24px;display:flex;gap:20px;align-items:center}
        .avatar{width:120px;height:120px;border-radius:999px;flex:0 0 120px;display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;background:#4b5563}
        .meta{flex:1}
        .name{font-size:1.5rem;font-weight:700;margin:0}
        .email{color:var(--muted);margin-top:6px}
        .bio{margin-top:12px;color:#374151}
        .actions{margin-left:auto;display:flex;gap:8px}
        .btn{padding:8px 14px;border-radius:8px;border:0;cursor:pointer}
        .btn-edit{background:#2563eb;color:#fff}
        .btn-message{background:#eef2ff;color:#1e3a8a}
        .stats{display:flex;gap:18px;margin-top:16px}
        .stat{background:#f9fafb;padding:10px 12px;border-radius:8px;text-align:center}
        .stat .n{font-weight:700}
        @media (max-width:640px){.card{flex-direction:column;align-items:flex-start}.actions{width:100%;justify-content:space-between}}
    </style>
</head>
<body>

    <!--NAVBAR DARI INDEX (DITAMBAHKAN DI SINI) -->
    <nav class="bg-white shadow-md sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="KRFSM Logo" class="h-8">
                <span class="font-semibold text-xl text-blue-600">KRFSM</span>
            </div>

            <div class="hidden md:flex space-x-6 text-sm font-medium">
                <a href="/" class="hover:text-blue-600">Beranda</a>
                <a href="#" class="hover:text-blue-600">Topik</a>
                <a href="#" class="hover:text-blue-600">Ranking</a>
                <a href="{{ route('profile') }}" class="hover:text-blue-600 font-semibold text-blue-600">Profile</a>
                <a href="{{ route('login') }}" class="hover:text-blue-600">Masuk</a>
            </div>
        </div>
    </nav>
    <!-- 🔵 NAVBAR SELESAI -->

    @php
        $user = $user ?? auth()->user();
        $initials = isset($user->name)
            ? collect(explode(' ', $user->name))->map(fn($p)=>substr($p,0,1))->take(2)->join('')
            : 'U';
    @endphp

    <div class="container">
        <div class="card">
            <div class="avatar">
                @if(isset($user) && !empty($user->avatar))
                    <img src="{{ asset('storage/'.$user->avatar) }}" alt="avatar"
                         style="width:100%;height:100%;object-fit:cover;border-radius:999px;">
                @else
                    <span style="font-size:32px">{{ strtoupper($initials) }}</span>
                @endif
            </div>

            <div class="meta">
                <h1 class="name">{{ $user->name ?? 'Nama Pengguna' }}</h1>
                <div class="email">{{ $user->email ?? 'email@example.com' }}</div>
                <div class="bio">{{ $user->bio ?? 'Belum ada bio. Tambahkan sedikit deskripsi tentang diri Anda.' }}</div>

                        <div class="stats">
                            <div class="stat">
                                <div class="n">{{ $user->posts_count ?? 0 }}</div>
                                <div class="muted">Posts</div>
                            </div>
                            <div class="stat">
                                <div class="n">{{ $user->followers_count ?? 0 }}</div>
                                <div class="muted">Followers</div>
                            </div>
                            <div class="stat">
                                <div class="n">{{ $user->followings_count ?? 0 }}</div>
                                <div class="muted">Following</div>
                            </div>
                        </div>
            </div>

            <div class="actions">
                        @php
                            $isMe = auth()->check() && auth()->id() === ($user->id ?? null);
                        @endphp

                        @if($isMe)
                            <a href="{{ route('profile.edit') }}" class="btn btn-edit">Edit Profile</a>
                        @else
                            @auth
                                @if(auth()->user()->isFollowing($user))
                                    <form action="{{ route('users.unfollow', $user->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button class="btn btn-edit">Unfollow</button>
                                    </form>
                                @else
                                    <form action="{{ route('users.follow', $user->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button class="btn btn-edit">Follow</button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-edit">Login to Follow</a>
                            @endauth
                        @endif

                        <a href="{{ 'mailto:' . ($user->email ?? '') }}" class="btn btn-message">Message</a>

            </div>
        </div>
    </div>

</body>
</html>
