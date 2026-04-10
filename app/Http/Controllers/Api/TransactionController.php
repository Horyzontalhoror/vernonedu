<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'sub_program_id' => 'required|exists:sub_programs,id',
        ]);

        $user = $request->user();

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'sub_program_id' => $request->sub_program_id,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Transaksi berhasil dibuat',
            'data' => $transaction
        ]);
    }
}
