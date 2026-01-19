<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        // cek login
        if (!session('logged_in')) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        // cek role admin
        if (session('user_role') !== 'admin') {
            abort(403, 'Akses khusus admin');
        }

        return $next($request);
    }
}
