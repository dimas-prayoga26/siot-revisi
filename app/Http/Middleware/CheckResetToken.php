<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PasswordResetToken;
use Symfony\Component\HttpFoundation\Response;

class CheckResetToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $token = $request->route('token');

        $isValidToken = PasswordResetToken::where('token', $token)->exists();

        if (!$isValidToken) {
            return redirect()->route('error.page.403');
        }

        return $next($request);
    }
}
