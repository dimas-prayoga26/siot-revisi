<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\TrashBin;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyIoTDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uniqueId = $request->header('X-IoT-Device-ID');

        $trashBin = TrashBin::where('unique_id', $uniqueId)->first();

        if (!$trashBin) {
            return response()->json(['error' => 'Unauthorized. Invalid unique ID.'], 401);
        }

        return $next($request);
    }
}
