<?php

namespace App\Http\Controllers\Api;

use Midtrans\Config;
use Midtrans\Snap;
use App\Models\SubProgram;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        // 🔥 fallback harga (biar tidak error)
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
            // 🔥 biar detail muncul di midtrans
            'item_details' => [
                [
                    'id' => $subProgram->id,
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => $subProgram->name,
                ]
            ],
        ];

        // 🔥 ambil snap token
        $snapToken = Snap::getSnapToken($params);

        // 🔥 simpan transaksi
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
    // 🔥 CALLBACK MIDTRANS (WAJIB)
    // =============================
    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');

        // ✅ validasi signature
        $signatureKey = hash('sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaction = Transaction::where('order_id', $request->order_id)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $status = $request->transaction_status;

        // ✅ mapping status midtrans → database
        if (in_array($status, ['capture', 'settlement'])) {
            $transaction->transaction_status = 'success';
            $pembayaranStatus = 'lunas';
        } elseif ($status == 'pending') {
            $transaction->transaction_status = 'pending';
            $pembayaranStatus = 'pending';
        } else {
            $transaction->transaction_status = 'failed';
            $pembayaranStatus = 'gagal';
        }

        $transaction->payment_type = $request->payment_type;
        $transaction->save();

        // ✅ SIMPAN KE TABEL PEMBAYARANS
        \App\Models\Pembayaran::updateOrCreate(
            ['sub_program_id' => $transaction->sub_program_id, 'peserta_id' => $transaction->user_id],
            [
                'jumlah' => $transaction->amount,
                'status' => $pembayaranStatus,
                'tanggal' => now(),
                'metode' => $request->payment_type,
            ]
        );

        return response()->json(['message' => 'OK']);
    }

}
