<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

    @if (file_exists(public_path('build')))
        @vite(['resources/css/app.css','resources/js/app.js'])
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modern-normalize/modern-normalize.css">
    @endif

    <style>
        body { font-family: Inter, sans-serif; background: #f3f4f6; padding: 40px; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 30px;
            border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.08); }
        .title { font-size: 1.6rem; font-weight: 700; margin-bottom: 20px; }
        label { font-weight: 600; margin-top: 12px; display: block; }
        input, textarea {
            width: 100%; padding: 10px; border-radius: 8px; margin-top: 6px;
            border: 1px solid #d1d5db; font-size: 1rem;
        }
        .btn-save {
            margin-top: 20px; background: #2563eb; color: #fff;
            padding: 12px 16px; border-radius: 8px; border: none; cursor: pointer;
            width: 100%; font-weight: 600; transition: background 0.2s;
        }
        .btn-save:hover { background: #1d4ed8; }
        .avatar-preview {
            width: 90px; height: 90px; border-radius: 999px; object-fit: cover; margin-top: 10px;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="title">Edit Profile</div>

    @if ($errors->any())
        <div style="background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($user->avatar)
        <form id="delete-avatar-form" action="{{ route('profile.avatar.delete') }}" method="POST">
            @csrf
        </form>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf

        <label>Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>

        <label>Bio</label>
        <textarea name="bio" rows="4">{{ old('bio', $user->bio) }}</textarea>

        <label>Avatar</label>
        <div class="mt-2 flex items-center space-x-4" style="display: flex; align-items: center; gap: 15px;">
            <div>
                @if ($user->avatar)
                    <img id="avatar-preview" src="{{ asset('storage/'.$user->avatar) }}" class="avatar-preview">
                @else
                    <img id="avatar-preview" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4b5563&color=fff&size=90" class="avatar-preview">
                @endif
                <div style="margin-top:6px;display:flex;gap:8px;align-items:center">
                    <div id="avatar-status" style="color:#16a34a;font-size:0.9rem;display:none">Tersimpan</div>
                    <button id="avatar-undo" type="button" style="display:none;padding:6px 8px;border-radius:6px;border:1px solid #e5e7eb;background:#fff;cursor:pointer">Undo</button>
                </div>
            </div>

            @if ($user->avatar)
                <button type="button" onclick="if(confirm('Hapus avatar?')) document.getElementById('delete-avatar-form').submit();" 
                        style="background: #ef4444; color: white; padding: 8px 12px; border-radius: 6px; border: none; cursor: pointer;">
                    Hapus Avatar
                </button>
            @endif
        </div>

        <label class="mt-4">Pilih Avatar Lucu</label>
        <input type="hidden" name="avatar_choice" id="avatar_choice" value="">
        <div class="grid grid-cols-5 gap-3 mt-2" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px;">
            @php
                $choices = ['avatars/choice1.svg','avatars/choice2.svg','avatars/choice3.svg','avatars/choice4.svg','avatars/choice5.svg'];
            @endphp
            @foreach($choices as $c)
                <button type="button" class="p-1 border rounded choice-btn" data-choice="{{ $c }}" style="background:transparent; border: 1px solid #d1d5db; border-radius: 8px; cursor: pointer;">
                    <img src="{{ asset('storage/'.$c) }}" alt="avatar" style="width:64px;height:64px;border-radius:12px;object-fit:cover; display: block;">
                </button>
            @endforeach
        </div>

        <button type="submit" class="btn-save">Simpan Perubahan</button>
    </form>
</div>

<script>
    (function(){
        const preview = document.getElementById('avatar-preview');
        const choiceButtons = document.querySelectorAll('.choice-btn');
        const choiceInput = document.getElementById('avatar_choice');
        const statusEl = document.getElementById('avatar-status');
        const undoBtn = document.getElementById('avatar-undo');
        const saveBtn = document.querySelector('.btn-save');

        if (!choiceButtons.length || !choiceInput || !preview) return;

        const current = '{{ $user->avatar }}';
        let prevChoice = current || '';
        let currentChoice = current || '';

        choiceButtons.forEach(btn => {
            btn.addEventListener('click', function(){
                const choice = this.getAttribute('data-choice');
                choiceInput.value = choice;
                const img = this.querySelector('img');
                if (img) preview.src = img.src;

                // visual highlight
                choiceButtons.forEach(b => b.style.outline = 'none');
                this.style.outline = '3px solid #3b82f6';

                prevChoice = currentChoice;

                // AJAX Save
                fetch("{{ route('profile.avatar.select') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ avatar_choice: choice })
                }).then(r => r.json()).then(data => {
                    if (data && data.success) {
                        currentChoice = choice;
                        if (undoBtn) undoBtn.style.display = 'inline-block';
                        if (statusEl) {
                            statusEl.style.display = 'block';
                            statusEl.textContent = 'Avatar dipilih';
                            setTimeout(()=> statusEl.style.display = 'none', 1800);
                        }
                    }
                }).catch(err => console.error('Error:', err));
            });
        });

        // Highlight avatar aktif saat halaman dimuat
        if (current) {
            choiceButtons.forEach(btn => {
                if (btn.getAttribute('data-choice') === current) {
                    btn.style.outline = '3px solid #3b82f6';
                }
            });
        }
    })();
</script>

</body>
</html>