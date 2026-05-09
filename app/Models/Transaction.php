<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LogUser;
use App\Models\SubProgram;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'snap_token',
        'payment_type',
        'transaction_status',
        'user_id',
        'sub_program_id',
    ];

    // 🔥 user dari log_users
    public function user()
    {
        return $this->belongsTo(LogUser::class, 'user_id');
    }

    // 🔥 relasi ke program
    public function subProgram()
    {
        return $this->belongsTo(SubProgram::class);
    }

    // 🔥 helper nama
    public function getNamaAttribute()
    {
        return $this->user?->nama ?? '-';
    }
}
