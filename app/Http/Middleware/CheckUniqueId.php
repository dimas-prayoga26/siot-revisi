<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\TrashBin;
use App\Models\WeightScale;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUniqueId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Mendapatkan unique_id dari header
        $uniqueId = $request->header('X-IoT-Device-ID');
        $pin = $request->input('pin');

        // Jika unique_id tidak ada dalam header, kembalikan respon Unauthorized
        if (!$uniqueId) {
            return response()->json(['error' => 'Unauthorized. Unique ID is missing.'], 401);
        }

        // Cek apakah unique_id ada di tabel WeightScale
        $weightScale = WeightScale::where('unique_id', $uniqueId)->first();
        if ($weightScale) {
            // Jika pin tidak disediakan atau tidak cocok, kembalikan respon Unauthorized
            if (!$pin || $weightScale->pin !== $pin) {
                return response()->json(['error' => 'Invalid PIN.'], 401);
            }
            // Tambahkan informasi ke request untuk digunakan di controller
            $request->attributes->set('weight_scale', $weightScale);
            return $next($request);
        }

        // Cek apakah unique_id ada di tabel TrashBin
        $trashBin = TrashBin::where('unique_id', $uniqueId)->first();
        if ($trashBin) {
            // Tambahkan informasi ke request untuk digunakan di controller
            $request->attributes->set('trash_bin', $trashBin);
            return $next($request);
        }

        // Jika unique_id tidak ditemukan di kedua tabel, kembalikan respon Unauthorized
        return response()->json(['error' => 'Unauthorized. Invalid unique ID.'], 401);
    }
}
