<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\Rule;

use App\Models\Peserta;

class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET PROFILE
    |--------------------------------------------------------------------------
    */

    public function me(Request $request)
    {
        $user = $request->user();

        $peserta = Peserta::where(
            'log_user_id',
            $user->id
        )->first();

        return response()->json([

            'id' => $user->id,

            'nama' => $user->nama,

            'email' => $user->email,

            'no_telepon' => $user->no_telepon,

            'status' => $user->status,

            'peserta' => [

                'jenis_kelamin' =>
                    $peserta?->jenis_kelamin,

                'tanggal_lahir' =>
                    $peserta?->tanggal_lahir,

                'alamat' =>
                    $peserta?->alamat,

            ],

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PROFILE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request)
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'nama' => [
                'required',
                'max:255',
            ],

            'email' => [
                'nullable',
                'email',

                Rule::unique('log_users', 'email')
                    ->ignore($user->id),
            ],

            'no_telepon' => [

                'required',

                Rule::unique(
                    'log_users',
                    'no_telepon'
                )->ignore($user->id),
            ],

            'jenis_kelamin' => [
                'nullable',
                'in:L,P',
            ],

            'tanggal_lahir' => [
                'nullable',
                'date',
            ],

            'alamat' => [
                'nullable',
            ],

            /*
            |--------------------------------------------------------------------------
            | PASSWORD
            |--------------------------------------------------------------------------
            */

            'new_password' => [
                'nullable',
                'min:6',
                'same:confirm_password',
            ],

            'confirm_password' => [
                'nullable',
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE USER
        |--------------------------------------------------------------------------
        */

        $updateData = [

            'nama' =>
                $request->nama,

            'email' =>
                $request->email,

            'no_telepon' =>
                $request->no_telepon,

        ];

        /*
        |--------------------------------------------------------------------------
        | UPDATE PASSWORD
        |--------------------------------------------------------------------------
        */

        if ($request->filled('new_password')) {

            $updateData['password'] =
                Hash::make(
                    $request->new_password
                );
        }

        $user->update($updateData);

        /*
        |--------------------------------------------------------------------------
        | UPDATE PESERTA
        |--------------------------------------------------------------------------
        */

        Peserta::updateOrCreate(

            [
                'log_user_id' => $user->id,
            ],

            [
                'jenis_kelamin' =>
                    $request->jenis_kelamin,

                'tanggal_lahir' =>
                    $request->tanggal_lahir,

                'alamat' =>
                    $request->alamat,

            ]
        );

        return response()->json([

            'message' =>
                'Profile berhasil diperbarui',

        ]);
    }
}
