<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user = null)
    {
        // Jika route memanggil /users/{user} maka $user akan di-resolve.
        // Kalau tidak, coba ambil user terautentikasi via Auth atau session buatan aplikasi.
        if (!$user) {
            $user = Auth::user();
            if (!$user && session('user_id')) {
                $user = User::find(session('user_id'));
            }
            if (!$user) {
                return redirect()->route('login');
            }
        }

        // Tambahkan beberapa atribut bantu (fallback ke 0 ketika relasi belum siap)
        $user->posts_count = $user->posts_count ?? 0;
        $user->followers_count = $user->followers_count ?? $user->followers()->count();
        $user->followings_count = $user->followings_count ?? $user->followings()->count();

        return view('profile', compact('user'));
    }
    public function edit()
    {
        $user = auth()->user() ?: (session('user_id') ? User::find(session('user_id')) : null);
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        return view('editprofile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'bio'   => 'nullable|string',
            'avatar' => 'nullable|image|max:2048'
        ]);

        $user = auth()->user() ?: (session('user_id') ? User::find(session('user_id')) : null);

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Upload avatar baru
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // Simpan data
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->bio   = $request->bio;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function follow(User $user)
    {
        $me = auth()->user() ?: (session('user_id') ? User::find(session('user_id')) : null);
        if (!$me) {
            return redirect()->route('login');
        }

        $me->follow($user);
        return back()->with('success', 'Mengikuti ' . $user->name);
    }

    public function unfollow(User $user)
    {
        $me = auth()->user() ?: (session('user_id') ? User::find(session('user_id')) : null);
        if (!$me) {
            return redirect()->route('login');
        }

        $me->unfollow($user);
        return back()->with('success', 'Berhenti mengikuti ' . $user->name);
    }
}
