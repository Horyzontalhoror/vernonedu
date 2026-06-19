<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Notifications\AdminValidationNotification;

class AuthController extends Controller
{
    //register
    public function register(Request $request)
    {
        $errors = [];

        // Validasi wajib isi
        if (empty(trim($request->nama ?? ''))) {
            $errors['nama'] = ['Nama wajib diisi']; }
        if (empty(trim($request->email ?? ''))) {
            $errors['email'] = ['Email wajib diisi']; }
        if (empty(trim($request->no_telepon ?? ''))) {
            $errors['no_telepon'] = ['Nomor telepon wajib diisi']; }
        if (empty($request->password)) {
            $errors['password'] = ['Password wajib diisi']; }
        if (empty($request->password_confirmation)) {
            $errors['password_confirmation'] = ['Konfirmasi password wajib diisi']; }

        // Jika ada field kosong, hentikan proses
        if (!empty($errors)) {
            return response()->json([ 'message' => 'Validasi gagal', 'errors' => $errors, ], 422);
        }
        // Validasi password sama
        if ($request->password !== $request->password_confirmation){
            $errors['password_confirmation'] = ['Password tidak sama']; }
        // Cek email sudah terdaftar
        if (LogUser::where('email', $request->email)->exists()) {
            $errors['email'] = ['Email sudah terdaftar']; }
        // Cek nomor telepon sudah terdaftar
        if (LogUser::where('no_telepon', $request->no_telepon)->exists()) {
            $errors['no_telepon'] = ['Nomor telepon sudah terdaftar']; }
        // Jika ada error validasi
        if (!empty($errors)) {
            return response()->json([ 'message' => 'Validasi gagal', 'errors' => $errors, ], 422); }

        // Simpan user
        $user = LogUser::create([
            'nama'       => $request->nama,
            'email'      => $request->email,
            'no_telepon' => $request->no_telepon,
            'password'   => Hash::make($request->password),
            'status'     => 'pending',
        ]);

        // Kirim notifikasi ke semua admin
        try {
            $admins = User::whereNotNull('email')->get();
            foreach ($admins as $admin) {
                $admin->notify(
                    new AdminValidationNotification(
                        title: 'Peserta Baru',
                        message: 'Peserta baru ' . $user->nama . ' menunggu validasi admin.',
                        url: '/admin/log-users'
                    )
                );
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim notifikasi admin: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Register berhasil, tunggu validasi admin'
        ]);
    }

    //login
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        //find user
        $user = LogUser::where( 'no_telepon', $request->login )

        ->orWhere( 'email', $request->login )

        ->first();

        //not found
        if (! $user) {
            return response()->json([ 'message' => 'Email atau nomor telepon tidak terdaftar' ], 404);
        }

        //wrong password
        if ( ! Hash::check( $request->password, $user->password ) ) {
            return response()->json([
                'message' => 'Password salah'
            ], 401);
        }

        //pending
        if ( $user->status === 'pending' ) {
            return response()->json([
                'message' => 'Akun menunggu validasi admin'
            ], 403);
        }

        //rejected
        if ( $user->status === 'rejected' ) {
            return response()->json([
                'message' => 'Akun ditolak admin'
            ], 403);
        }

        //token
        $token = $user
            ->createToken( 'auth_token' )
            ->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user,
        ]);
    }

    //logout
    public function logout(Request $request)
    {
        $request
            ->user()
            ->currentAccessToken()
            ->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }

    //me
    public function me(Request $request)
    {
        return response()->json( $request->user() );
    }
}
