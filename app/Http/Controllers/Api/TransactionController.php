<?php

namespace App\Http\Controllers\Api;

use Midtrans\Config;
use Midtrans\Snap;
use App\Models\SubProgram;
use App\Models\Transaction;
use App\Models\Peserta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    // =============================
    // 🔥 CREATE TRANSACTION (MIDTRANS)
    // =============================
    public function createTransaction(Request $request)
    {
        $request->validate([
            'sub_program_id' => 'required|exists:sub_programs,id',
        ]);

        $user = auth()->user();

        $subProgram = SubProgram::findOrFail($request->sub_program_id);

        $amount = (int) ($subProgram->harga ?? 100000);

        // 🔥 config midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');

        $orderId = 'ORDER-' . Str::uuid();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $user->nama,
                'phone' => $user->no_telepon,
            ],
            'item_details' => [
                [
                    'id' => $subProgram->id,
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => $subProgram->name,
                ]
            ],
            'callbacks' => [
                    'finish' => url('/dashboard')
                ]
        ];

        $snapToken = Snap::getSnapToken($params);

        Transaction::create([
            'user_id' => $user->id,
            'sub_program_id' => $subProgram->id,
            'order_id' => $orderId,
            'amount' => $amount,
            'snap_token' => $snapToken,
            'transaction_status' => 'pending',
        ]);

        return response()->json([
            'snap_token' => $snapToken,
        ]);
    }

    // =============================
    // 🔥 CALLBACK MIDTRANS
    // =============================
    public function callback(Request $request)
    {
        Log::info('MIDTRANS CALLBACK:', $request->all());

        $serverKey = config('services.midtrans.server_key');

        $signatureKey = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signatureKey !== $request->signature_key) {

            return response()->json([
                'message' => 'Invalid signature'
            ], 403);

        }

        $transaction = Transaction::where(
            'order_id',
            $request->order_id
        )->first();

        if (!$transaction) {

            return response()->json([
                'message' => 'Not found'
            ], 404);

        }

        $status = $request->transaction_status;

        /*
        |--------------------------------------------------------------------------
        | UPDATE TRANSACTION
        |--------------------------------------------------------------------------
        */

        $transaction->update([

            'transaction_status' => $status,

            'payment_type' =>
                $request->payment_type,

        ]);

        /*
        |--------------------------------------------------------------------------
        | SUCCESS PAYMENT
        |--------------------------------------------------------------------------
        */

        if (in_array($status, [
            'capture',
            'settlement'
        ])) {

            // peserta
            $peserta = Peserta::firstOrCreate(

                [
                    'log_user_id' =>
                        $transaction->user_id,
                ],

                [
                    'status' => 'active',
                ]

            );

            // enrollment
            $peserta->subPrograms()
                ->syncWithoutDetaching([

                    $transaction->sub_program_id

                ]);
        }

        return response()->json([
            'message' => 'OK'
        ]);
    }
}
