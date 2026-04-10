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
        $logUser = LogUser::create([
            'nama' => $data['nama'] ?? null,
            'no_telepon' => $data['no_telepon'] ?? null,
            'status' => $data['status'] ?? 'active',
            'password' => Hash::make($data['password']),
        ]);

        $data['log_user_id'] = $logUser->id;

        unset($data['nama'], $data['no_telepon'], $data['status'], $data['password']);

        return $data;
    }
}
