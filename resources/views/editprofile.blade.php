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
        padding: 10px 16px; border-radius: 8px; border: none; cursor: pointer;
        width: 100%; font-weight: 600;
    }
    .avatar-preview {
        width: 90px; height: 90px; border-radius: 999px; object-fit: cover; margin-top: 10px;
    }
</style>
</head>

<body>

<div class="container">
    <div class="title">Edit Profile</div>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf

        <label>Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>

        <label>Bio</label>
        <textarea name="bio" rows="4">{{ old('bio', $user->bio) }}</textarea>

        <label>Avatar</label>

        <div class="mt-2 flex items-center space-x-4">
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

            <div>
                @if ($user->avatar)
                    <form action="{{ route('profile.avatar.delete') }}" method="POST" onsubmit="return confirm('Hapus avatar?');">
                        @csrf
                        <button type="submit" class="px-3 py-2 bg-red-500 text-white rounded">Hapus Avatar</button>
                    </form>
                @endif
            </div>
        </div>

        <label class="mt-4">Pilih Avatar Lucu</label>
        <input type="hidden" name="avatar_choice" id="avatar_choice" value="">
        <div class="grid grid-cols-5 gap-3 mt-2">
            @php
                $choices = ['avatars/choice1.svg','avatars/choice2.svg','avatars/choice3.svg','avatars/choice4.svg','avatars/choice5.svg'];
            @endphp
            @foreach($choices as $c)
                <button type="button" class="p-1 border rounded choice-btn" data-choice="{{ $c }}" style="background:transparent">
                    <img src="{{ asset('storage/'.$c) }}" alt="avatar" style="width:64px;height:64px;border-radius:12px;object-fit:cover">
                </button>
            @endforeach
        </div>

        <button class="btn-save">Simpan Perubahan</button>
    </form>
</div>

</body>
<script>
    (function(){
        const preview = document.getElementById('avatar-preview');
        const choiceButtons = document.querySelectorAll('.choice-btn');
        const choiceInput = document.getElementById('avatar_choice');
        if (!choiceButtons.length || !choiceInput || !preview) return;
        const statusEl = document.getElementById('avatar-status');
        const undoBtn = document.getElementById('avatar-undo');
        const saveBtn = document.querySelector('.btn-save');
        // current must be declared before usage
        const current = '{{ $user->avatar }}';
        let prevChoice = current || '';
        let currentChoice = current || '';

        choiceButtons.forEach(btn => {
            btn.addEventListener('click', function(){
                const choice = this.getAttribute('data-choice');
                choiceInput.value = choice;
                const img = this.querySelector('img');
                if (img) preview.src = img.src;
                // visual highlight for selected
                choiceButtons.forEach(b => b.classList.remove('ring-2','ring-blue-500'));
                this.classList.add('ring-2','ring-blue-500');

                // store previous choice for undo
                prevChoice = currentChoice;

                // send AJAX to save selection
                fetch("{{ route('profile.avatar.select') }}", {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ avatar_choice: choice })
                }).then(async r => {
                    if (!r.ok) throw new Error('HTTP ' + r.status);
                    return r.json();
                }).then(data => {
                    if (data && data.success) {
                        currentChoice = choice;
                        // show undo
                        if (undoBtn) { undoBtn.style.display = 'inline-block'; }
                        if (statusEl) {
                            statusEl.style.display = 'block';
                            statusEl.textContent = 'Avatar tersimpan';
                            setTimeout(()=> statusEl.style.display = 'none', 1800);
                        }
                        if (data.avatar) preview.src = data.avatar;
                    } else {
                        alert('Gagal menyimpan avatar');
                    }
                }).catch(err=>{ console.error('avatar select error', err); alert('Gagal menyimpan avatar (cek koneksi atau login)'); });
            });
        });
        // initialize highlight if user has a default avatar
        if (current) {
            choiceButtons.forEach(btn => {
                if (btn.getAttribute('data-choice') === current) {
                    btn.classList.add('ring-2','ring-blue-500');
                }
            });
        }

        // undo handler
        if (undoBtn) {
            undoBtn.addEventListener('click', function(){
                // revert to prevChoice (could be empty/null)
                if (!prevChoice) {
                        // remove avatar
                        fetch("{{ route('profile.avatar.delete') }}", {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        }).then(async r => {
                            if (!r.ok) throw new Error('HTTP ' + r.status);
                            return r.json();
                        }).then(data => {
                            if (data && data.success) {
                                preview.src = 'https://ui-avatars.com/api/?name='+encodeURIComponent('{{ $user->name }}')+'&background=4b5563&color=fff&size=90';
                                currentChoice = '';
                                if (saveBtn) { saveBtn.disabled = false; saveBtn.style.opacity = '1'; }
                                undoBtn.style.display = 'none';
                            } else {
                                alert('Gagal undo');
                            }
                        }).catch(err=>{ console.error('avatar delete error', err); alert('Gagal undo (cek koneksi atau login)'); });
                } else {
                    // restore previous default choice
                        fetch("{{ route('profile.avatar.select') }}", {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ avatar_choice: prevChoice })
                        }).then(async r => {
                            if (!r.ok) throw new Error('HTTP ' + r.status);
                            return r.json();
                        }).then(data => {
                            if (data && data.success) {
                                if (data.avatar) preview.src = data.avatar;
                                currentChoice = prevChoice;
                                if (saveBtn) { saveBtn.disabled = false; saveBtn.style.opacity = '1'; }
                                undoBtn.style.display = 'none';
                            } else {
                                alert('Gagal undo');
                            }
                        }).catch(err=>{ console.error('avatar restore error', err); alert('Gagal undo (cek koneksi atau login)'); });
                }
            });
        }
    })();
</script>
</html>
