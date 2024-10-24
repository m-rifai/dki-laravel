<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request; // Import yang benar
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request  // Type-hinting yang benar
     * @param  \Closure  $next
     * @param  string  ...$roles  // Parameter variadik untuk multiple roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Pastikan pengguna terautentikasi
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        $user = Auth::user();

        // Periksa apakah pengguna memiliki salah satu dari roles yang diizinkan
        if (!in_array($user->role->name, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
