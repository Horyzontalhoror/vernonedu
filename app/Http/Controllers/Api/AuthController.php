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
        $request->validate([

            'nama' =>

                'required|string|max:255',

            'email' =>

                'required|email|unique:log_users,email',

            'no_telepon' =>

                'required|string|unique:log_users,no_telepon',

            'password' =>

                'required|min:6|confirmed',

        ]);

        //status
        $status = 'pending';

        //create user
        $user = LogUser::create([

            'nama' =>

                $request->nama,

            'email' =>

                $request->email,

            'no_telepon' =>

                $request->no_telepon,

            'password' =>

                Hash::make(
                    $request->password
                ),

            'status' =>

                $status,

        ]);

        //notif admin
        $admins = User::all();

        foreach ($admins as $admin) {

            $admin->notify(

                new AdminValidationNotification(

                    title:
                        'Peserta Baru',

                    message:
                        'Peserta baru ' .
                        $user->nama .
                        ' menunggu validasi admin.',

                    url:
                        '/admin/log-users'

                )

            );
        }

        return response()->json([

            'message' =>

                $status === 'active'

                ? 'Register berhasil'

                : 'Register berhasil, tunggu validasi admin'

        ]);
    }

    //login
    public function login(Request $request)
    {
        $request->validate([

            'login' =>

                'required',

            'password' =>

                'required',

        ]);

        //find user
        $user = LogUser::where(

            'no_telepon',

            $request->login

        )

        ->orWhere(

            'email',

            $request->login

        )

        ->first();

        //not found
        if (! $user) {

            return response()->json([

                'message' =>

                    'Email atau nomor telepon tidak terdaftar'

            ], 404);
        }

        //wrong password
        if (

            ! Hash::check(

                $request->password,

                $user->password

            )

        ) {

            return response()->json([

                'message' =>

                    'Password salah'

            ], 401);
        }

        //pending
        if (

            $user->status ===
            'pending'

        ) {

            return response()->json([

                'message' =>

                    'Akun menunggu validasi admin'

            ], 403);
        }

        //rejected
        if (

            $user->status ===
            'rejected'

        ) {

            return response()->json([

                'message' =>

                    'Akun ditolak admin'

            ], 403);
        }

        //token
        $token = $user

            ->createToken(
                'auth_token'
            )

            ->plainTextToken;

        return response()->json([

            'message' =>

                'Login berhasil',

            'token' =>

                $token,

            'user' =>

                $user,

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

            'message' =>

                'Logout berhasil'

        ]);
    }

    //me
    public function me(Request $request)
    {
        return response()->json(
            $request->user()
        );
    }
}
