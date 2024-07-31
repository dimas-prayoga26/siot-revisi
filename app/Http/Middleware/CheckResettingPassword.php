<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckResettingPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah request berasal dari formulir reset password
        if (!$request->isMethod('post')) {
            // Jika tidak, redirect ke halaman lain atau tampilkan pesan error
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        // Lanjutkan ke proses reset password jika request berasal dari formulir reset password
        return $next($request);
    }
}
