<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;    
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

public function prosesLogin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->with('error', 'Email atau password salah!');
    }

    // record previous last_login_at in session so we can show notifications since last login
    $previousLastLogin = $user->last_login_at ? $user->last_login_at->toDateTimeString() : null;

    // update user's last_login_at to now
    $user->last_login_at = now();
    $user->save();

    session([
        'logged_in' => true,
        'user_id' => $user->id,
        'user_name' => $user->name,
        'user_email' => $user->email,
        'user_role' => $user->role, // ⬅️ PENTING
        'last_seen_notifications_at' => $previousLastLogin
    ]);


    if ($user->role === 'admin') {
        return redirect()->route('admin.index')
            ->with('success', 'Selamat datang Admin!');
    }

return redirect()->route('home')
    ->with('success', 'Berhasil login!');

}


    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login')->with('success', 'Berhasil logout');
    }

    public function register()
{
    return view('register');
}

public function registerProses(Request $request)
{
    $request->validate([
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    return redirect()->route('login')
        ->with('success', 'Akun berhasil dibuat, silakan login!');
}
}