<?php

namespace App\Filament\Resources\Pesertas\Pages;

use App\Filament\Resources\Pesertas\PesertaResource;
use App\Models\LogUser;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreatePeserta extends CreateRecord
{
    protected static string $resource = PesertaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 🔥 VALIDASI MINIMAL (biar tidak silent error)
        if (empty($data['password'])) {
            throw new \Exception('Password wajib diisi');
        }

        $logUser = LogUser::create([
            'nama' => $data['nama'] ?? null,
            'email' => $data['email'] ?? null,
            'no_telepon' => $data['no_telepon'] ?? null,
            'status' => $data['status'] ?? 'active',
            'password' => Hash::make($data['password']),
        ]);

        // 🔥 RELASI
        $data['log_user_id'] = $logUser->id;

        // 🔥 JANGAN masuk ke tabel pesertas
        unset(
            $data['nama'],
            $data['email'],
            $data['no_telepon'],
            $data['status'],
            $data['password']
        );

        return $data;
    }
}
