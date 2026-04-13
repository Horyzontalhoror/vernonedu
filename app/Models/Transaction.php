<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'sub_program_id',
        'order_id',
        'amount',
        'snap_token',
        'transaction_status',
        'payment_type',
    ];

    public function user()
    {
        return $this->belongsTo(LogUser::class, 'user_id');
    }

    public function subProgram()
    {
        return $this->belongsTo(SubProgram::class);
    }
}
