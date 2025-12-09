<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role user sesuai dengan yang diminta route
        if (Auth::user()->role !== $role) {
            // JANGAN gunakan abort(403) jika ingin redirect.

            // Opsi 1: Kembalikan ke halaman sebelumnya (back) dengan pesan error
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');

            // Opsi 2 (Alternatif): Jika ingin paksa ke halaman login
            // return redirect()->route('login')->with('error', 'Silakan login dengan akun yang sesuai.');
        }

        return $next($request);
    }
}
