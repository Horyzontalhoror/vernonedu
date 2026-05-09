<?php

namespace App\Http\Controllers\Api;

use Midtrans\Config;
use Midtrans\Snap;
use App\Models\SubProgram;
use App\Models\Transaction;
use App\Models\Pembayaran;
use App\Models\Peserta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

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

        // 🔥 ANTI DOUBLE PROCESS
        if ($transaction->transaction_status === 'success') {
            return response()->json(['message' => 'Already processed']);
        }

        $status = $request->transaction_status;

        // =============================
        // 🔥 MAPPING STATUS
        // =============================
        if (in_array($status, ['capture', 'settlement'])) {
            $transaction->transaction_status = 'success';
            $pembayaranStatus = 'lunas';

            // ✅ MASUKKAN KE PESERTA
            Peserta::updateOrCreate(
                [
                    'log_user_id' => $transaction->user_id, // 🔥 FIX
                    'sub_program_id' => $transaction->sub_program_id,
                ],
                [
                    'status' => 'aktif',
                ]
            );

        } elseif ($status == 'pending') {
            $transaction->transaction_status = 'pending';
            $pembayaranStatus = 'pending';

        } else {
            $transaction->transaction_status = 'failed';
            $pembayaranStatus = 'gagal';
        }

        $transaction->payment_type = $request->payment_type;

        // 🔥 OPTIONAL: simpan raw response (kalau ada kolomnya)
        if (Schema::hasColumn('transactions', 'midtrans_response')) {
            $transaction->midtrans_response = json_encode($request->all());
        }

        $transaction->save();

        // =============================
        // 🔥 SIMPAN KE PEMBAYARAN
        // =============================
        // 🔥 pastikan peserta sudah ada (dari step sebelumnya)
        $peserta = Peserta::where('log_user_id', $transaction->user_id)
            ->where('sub_program_id', $transaction->sub_program_id)
            ->first();

        // kalau belum ada (safety)
        if (!$peserta) {
            $peserta = Peserta::create([
                'user_id' => $transaction->user_id,
                'sub_program_id' => $transaction->sub_program_id,
                'status' => 'aktif',
            ]);
        }

        // 🔥 simpan pembayaran (pakai peserta_id)
        Pembayaran::updateOrCreate(
            [
                'peserta_id' => $peserta->id,
                'sub_program_id' => $transaction->sub_program_id,
            ],
            [
                'jumlah' => $transaction->amount,
                'status' => $pembayaranStatus,
                'tanggal' => now(),
                'metode' => $request->payment_type,
            ]
        );

        // 🔥 kalau sukses → pastikan status peserta aktif
        if ($pembayaranStatus === 'lunas') {
            $peserta->update([
                'status' => 'aktif'
            ]);
        }

        return response()->json(['message' => 'OK']);
    }
}
