<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Periksa apakah sesi pengguna valid
            if ($user->remember_token !== session()->getId()) {
                // Jika sesi tidak valid, atur ulang token "remember"
                $user->remember_token = null;
                $user->save();

                // Logout pengguna dan arahkan ke halaman login
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('error', 'Sesi Anda telah habis. Silakan login kembali.');
            }
        }

        return $next($request);
    }
}
