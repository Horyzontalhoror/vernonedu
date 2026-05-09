<?php

namespace App\Filament\Resources\Pesertas\Pages;

use App\Filament\Resources\Pesertas\PesertaResource;
use App\Models\LogUser;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditPeserta extends EditRecord
{
    protected static string $resource = PesertaResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $logUser = $this->record->logUser;

        $data['nama'] = $logUser->nama ?? null;
        $data['email'] = $logUser->email ?? null;
        $data['no_telepon'] = $logUser->no_telepon ?? null;
        $data['status'] = $logUser->status ?? 'active';
        $data['password'] = null;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $logUser = $this->record->logUser;

        if (!$logUser) {
            throw new \Exception("LogUser tidak ditemukan");
        }

        $logUser->fill([
            'nama' => !empty($data['nama']) ? $data['nama'] : $logUser->nama,
            'email' => !empty($data['email']) ? $data['email'] : $logUser->email,
            'no_telepon' => !empty($data['no_telepon']) ? $data['no_telepon'] : $logUser->no_telepon,
            'status' => $data['status'] ?? $logUser->status ?? 'active',
        ]);

        if (!empty($data['password'])) {
            $logUser->password = Hash::make($data['password']);
        }

        $logUser->save();

        // 🔥 pastikan relasi aman
        if ($this->record->log_user_id !== $logUser->id) {
            $this->record->log_user_id = $logUser->id;
            $this->record->save();
        }

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
