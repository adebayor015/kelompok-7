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

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>

        <label>Bio</label>
        <textarea name="bio" rows="4">{{ old('bio', $user->bio) }}</textarea>

        <label>Avatar</label>
        <input type="file" name="avatar">

        @if ($user->avatar)
            <img src="{{ asset('storage/'.$user->avatar) }}" class="avatar-preview">
        @endif

        <button class="btn-save">Simpan Perubahan</button>
    </form>
</div>

</body>
</html>
