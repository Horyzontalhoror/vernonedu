<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogUser;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * 🔹 REGISTER
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:log_users,email',
            'no_telepon' => 'required|string|unique:log_users,no_telepon',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = 'pending'; // atau 'active' untuk testing

        $user = LogUser::create([
            'nama' => $request->nama,
            'email' => $request->email, // ✅ tambah email
            'no_telepon' => $request->no_telepon,
            'password' => Hash::make($request->password),
            'status' => $status,
        ]);

        return response()->json([
            'message' => $status === 'active'
                ? 'Register berhasil, akun langsung aktif'
                : 'Register berhasil, tunggu validasi admin'
        ]);
    }

    /**
     * 🔹 LOGIN (EMAIL ATAU NO HP)
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required', // ✅ bukan no_telepon lagi
            'password' => 'required',
        ]);

        // 🔍 cari user berdasarkan email ATAU no telepon
        $user = LogUser::where('no_telepon', $request->login)
            ->orWhere('email', $request->login)
            ->first();

        // ❌ user tidak ditemukan
        if (!$user) {
            return response()->json([
                'message' => 'Email atau nomor telepon tidak terdaftar'
            ], 404);
        }

        // ❌ password salah
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Password salah'
            ], 401);
        }

        // ❌ belum aktif
        if ($user->status === 'pending') {
            return response()->json([
                'message' => 'Akun Anda sedang menunggu validasi admin'
            ], 403);
        }

        // ❌ ditolak
        if ($user->status === 'rejected') {
            return response()->json([
                'message' => 'Akun Anda ditolak oleh admin'
            ], 403);
        }

        // 🔥 buat token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user,
        ]);
    }

    /**
     * 🔹 LOGOUT
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }

    /**
     * 🔹 GET USER (ME)
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
