<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordEmail;
use App\Models\PasswordResetToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper; // Sesuaikan dengan namespace yang benar

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','refresh', 'resetPassword']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'fcm_token' => 'nullable',
        ]);

        if ($validator->fails()) {
            return Helper::validationFailMessage($validator->messages()->first());
        }


        try {
            if (!$token = Auth::guard('api')->attempt($request->only(['email', 'password']))) {
                return Helper::badRequestMessage("Email atau Password yang Anda masukan salah");
            }
            // $user = User::where('email', $request->email)->first();
            // if (!$token = Auth::guard('api')->login($user)) {
            //     return Helper::badRequestMessage("Email atau Password yang Anda masukan salah");
            // }

            if ($request->has('fcm_token')) {
                User::where('id', Auth::guard('api')->user()->id)->update(['fcm_token' => $request->fcm_token]);
            }

            return $this->createNewToken($token);
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            auth()->logout();
            return Helper::successMessage("Berhasil logout");
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return response()->json([
            'access_token' => auth()->guard('api')->refresh(),
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->guard('api')->factory()->getTTL() * 1,
            'user' => auth()->guard('api')->user()->load('userData', 'trashBin'),
            'role_name' => Helper::getRoleName(auth()->guard('api')->user()->id),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return Helper::validationFailMessage($validator->messages()->first());
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return Helper::validationFailMessage('Email tidak ditemukan');
        }

        $existingToken = PasswordResetToken::where('email', $request->email)->first();
        // dd($existingToken);
        if ($existingToken) {
            // Periksa nilai is_used
            if ($existingToken->is_used) {
                $existingToken->is_used = false;
                $existingToken->save();
            }
            // Gunakan token yang ada
            $token = $existingToken->token;
            $expiredAt = $existingToken->expired_at;
        }
            // Jika tidak, buat token baru
            $token = $user->id . '-' . now()->format('Ymd') . '-' . Str::random(10);
            $expiredAt = Carbon::now()->addHours(24);
            $createdAt = Carbon::now();
            
            // dd($expiredAt);
            // Update token atau buat token baru
            PasswordResetToken::updateOrCreate(
                ['email' => $request->email],
                ['token' => $token, 'expired_at' => $expiredAt, 'created_at' => $createdAt]
            );

        Mail::to($request->email)->send(new ResetPasswordEmail($token));

        return Helper::successMessage('Tautan reset kata sandi telah dikirim ke email Anda');
    }
}
