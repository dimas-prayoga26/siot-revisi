<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserData;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordEmail;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller

{

    public function login(Request $request)
    {
        $request->session()->forget('resetting_password');

        // Validasi input untuk mencegah SQL injection
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Set current session id
            $user->remember_token = session()->getId();
            $user->save();

            // Pengecekan role menggunakan Spatie Permission
            if ($user->hasRole('admin') || $user->hasRole('superadmin')) {
                session()->flash('success', 'Login berhasil! Selamat datang di dashboard.');
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('login')->with('error', 'Email atau password salah!');
            }

            // Tambahkan redirect untuk role lain jika diperlukan
        } else {
            // Jika login gagal, kembalikan ke halaman login dengan pesan error
        }
    }



    public function mailSend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => __('Email tidak ditemukan.')]);
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

        return back()->with(['status' => __('Email reset password telah dikirim.')]);
    }



    public function showResetPasswordForm($token) {
        $email = PasswordResetToken::where('token', $token)->pluck('email')->first();

        $user = User::where('email', $email)->first();
    
        $userData = UserData::where('user_id', $user->id)->first();
        $name = $userData->name;
    
        return view('auth.reset-password', ['name' => $name, 'token' => $token, 'email' => $email]);
    }

    public function resetPassword(Request $request)
    {
        $token = $request->token;

        $resetToken = PasswordResetToken::where('token', $token)->first();

        if (!$resetToken || $resetToken->is_used) {
            return redirect()->route('login')->with('error' ,'Token reset password tidak valid.');
        }

        if ($resetToken->expired_at && $resetToken->expired_at < Carbon::now()) {
            return redirect()->route('login')->with('error' ,'Token reset password telah kadaluarsa.');
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => __('User tidak ditemukan.')]);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        $resetToken->is_used = true;
        $resetToken->used_at = Carbon::now();
        $resetToken->save();

        event(new PasswordReset($user));

        return redirect()->route('login')->with('success', 'Password berhasil direset.');
    }

    public function logout(Request $request)
    {
        // Pastikan pengguna terautentikasi
        if (Auth::check()) {
            $user = Auth::user();
            
            // Debugging untuk melihat data pengguna

            // Nullify remember token
            $user->remember_token = null;
            $user->save();

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            session()->flash('warning', 'Logout berhasil!');
            return redirect()->route('login')->with('success', 'Logout berhasil.');
        } else {
            // Jika pengguna tidak terautentikasi, arahkan kembali ke halaman login
            return redirect()->route('login')->with('error', 'Anda tidak terautentikasi.');
        }
    }
}
