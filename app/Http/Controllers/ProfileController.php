<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        // Load user's questions (paginate) with relations
        $questions = $user->questions()->with(['answers','topic'])->latest()->paginate(10);

        return view('profile', compact('user', 'questions'));
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

        // Handle choice of prebuilt avatar (one of defaults)
        $defaultAvatars = [
            'avatars/choice1.svg',
            'avatars/choice2.svg',
            'avatars/choice3.svg',
            'avatars/choice4.svg',
            'avatars/choice5.svg',
        ];

        if ($request->input('avatar_choice') && in_array($request->input('avatar_choice'), $defaultAvatars)) {
            $choice = $request->input('avatar_choice');
            // delete old custom avatar if exists and not a default
            if ($user->avatar && !in_array($user->avatar, $defaultAvatars) && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $choice;
        }

        // Note: file uploads are no longer handled from the edit UI.
        // If you still POST a file, it will be ignored by this endpoint.

        // Simpan data
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->bio   = $request->bio;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function removeAvatar(Request $request)
    {
        $user = auth()->user() ?: (session('user_id') ? User::find(session('user_id')) : null);
        if (!$user) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
            return redirect()->route('login');
        }

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }
        $user->avatar = null;
        $user->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Avatar berhasil dihapus.');
    }

    public function selectAvatar(Request $request)
    {
        $user = auth()->user() ?: (session('user_id') ? User::find(session('user_id')) : null);
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $defaultAvatars = [
            'avatars/choice1.svg',
            'avatars/choice2.svg',
            'avatars/choice3.svg',
            'avatars/choice4.svg',
            'avatars/choice5.svg',
        ];

        $choice = $request->input('avatar_choice');
        if (!$choice || !in_array($choice, $defaultAvatars)) {
            return response()->json(['error' => 'Invalid choice'], 422);
        }

        // delete old custom avatar if exists and not a default
        if ($user->avatar && !in_array($user->avatar, $defaultAvatars) && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = $choice;
        $user->save();

        return response()->json(['success' => true, 'avatar' => asset('storage/'.$choice)]);
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

    // Show notifications for answers to the user's questions
    public function notifications()
    {
        $user = auth()->user() ?: (session('user_id') ? User::find(session('user_id')) : null);
        if (!$user) {
            return redirect()->route('login');
        }

        // Determine cutoff: prefer session-stored previous login, then user's last_seen_notifications_at, else user's created_at
        $sessionCutoff = session('last_seen_notifications_at');
        $dbCutoff = $user->last_seen_notifications_at;
        $cutoff = null;
        if ($sessionCutoff) {
            $cutoff = \Carbon\Carbon::parse($sessionCutoff);
        } elseif ($dbCutoff) {
            $cutoff = \Carbon\Carbon::parse($dbCutoff);
        } else {
            $cutoff = $user->created_at ?? now()->subYears(5);
        }

        // Fetch answers made by others on the user's questions since cutoff
        $answers = \App\Models\Answer::whereHas('question', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('user_id', '<>', $user->id)
          ->where('created_at', '>', $cutoff)
          ->with(['question','user'])
          ->latest()
          ->paginate(20);

        // update user's last_seen_notifications_at to now so subsequent visits only show newer answers
        $user->last_seen_notifications_at = now();
        $user->save();
        session(['last_seen_notifications_at' => $user->last_seen_notifications_at->toDateTimeString()]);

        return view('profile_notifications', compact('user','answers'));
    }
}
