<?php

namespace App\Http\Middleware;

use App\Models\WeightScale;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyIotWeightScale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uniqueId = $request->header('X-IoT-Device-ID');

        $trashBin = WeightScale::where('unique_id', $uniqueId)->first();

        if (!$trashBin) {
            return response()->json(['error' => 'Tes.'], 401);
        }

        return $next($request);
    }
}
