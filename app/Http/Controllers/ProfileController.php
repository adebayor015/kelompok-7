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

        // Load counts for better performance and fallback to 0
        $user->loadCount(['questions as posts_count', 'followers', 'followings']);
        $user->followers_count = $user->followers_count ?? $user->followers_count;
        $user->followings_count = $user->followings_count ?? $user->followings_count;

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

    public function follow(Request $request, User $user)
    {
        $me = auth()->user() ?: (session('user_id') ? User::find(session('user_id')) : null);
        if (!$me) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
            return redirect()->route('login');
        }

        $me->follow($user);
        // reload counts
        $user->loadCount('followers');
        $me->loadCount('followings');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'followers_count' => $user->followers_count,
                'followings_count' => $me->followings_count,
            ]);
        }

        return back()->with('success', 'Mengikuti ' . $user->name);
    }

    public function unfollow(Request $request, User $user)
    {
        $me = auth()->user() ?: (session('user_id') ? User::find(session('user_id')) : null);
        if (!$me) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
            return redirect()->route('login');
        }

        $me->unfollow($user);
        // reload counts
        $user->loadCount('followers');
        $me->loadCount('followings');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'followers_count' => $user->followers_count,
                'followings_count' => $me->followings_count,
            ]);
        }

        return back()->with('success', 'Berhenti mengikuti ' . $user->name);
    }

    // Show followers list for a user
    public function followers(User $user)
    {
        $users = $user->followers()->paginate(20);
        return view('follows', [
            'title' => 'Followers of ' . $user->name,
            'users' => $users,
        ]);
    }

    // Show followings list for a user
    public function following(User $user)
    {
        $users = $user->followings()->paginate(20);
        return view('follows', [
            'title' => 'Following of ' . $user->name,
            'users' => $users,
        ]);
    }
}
