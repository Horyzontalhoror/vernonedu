<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Peserta;
use App\Notifications\JadwalAvailableNotification;

class Jadwal extends Model
{
    //
    protected $fillable = [
        'sub_program_id',
        'instruktur_id',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'status',
        'keterangan'
    ];
    public function subProgram()
    {
        return $this->belongsTo(SubProgram::class);
    }

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class);
    }

    protected static function booted()
    {
        static::created(function ($jadwal) {

            /*HANYA KIRIM SEKALI*/

            if (

                Jadwal::where(
                    'sub_program_id',
                    $jadwal->sub_program_id
                )->count() > 1

            ) {

                return;
            }

            /*PESERTA*/

            $pesertas = Peserta::whereHas(

                'subPrograms',

                function ($q) use ($jadwal) {

                    $q->where(
                        'sub_program_id',
                        $jadwal->sub_program_id
                    );
                }

            )

            ->with('logUser')

            ->get();

            /*NOTIFY*/

            foreach ($pesertas as $peserta) {

                if (! $peserta->logUser) {

                    continue;
                }

                $peserta
                    ->logUser
                    ->notify(

                        new JadwalAvailableNotification(
                            $jadwal
                        )

                    );
            }
        });
    }

}
