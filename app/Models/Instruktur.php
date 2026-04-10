<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instruktur extends Model
{
    //
    protected $fillable = [
        'nama',
        'no_telepon',
        'jabatan',
        'alamat'
    ];
}
