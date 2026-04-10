<?php

namespace App\Filament\Resources\Pesertas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PesertaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pribadi')
                    ->schema([
                        TextEntry::make('logUser.nama')
                            ->label('Nama'),

                        TextEntry::make('email'),

                        TextEntry::make('logUser.no_telepon')
                            ->label('No Telepon'),

                        TextEntry::make('jenis_kelamin'),

                        TextEntry::make('tanggal_lahir')
                            ->date(),

                        TextEntry::make('alamat')
                            ->columnSpanFull()
                            ->wrap(),
                    ])
                    ->columns(2),

                Section::make('Akun Peserta')
                    ->schema([
                        TextEntry::make('logUser.status')
                            ->badge()
                            ->colors([
                                'warning' => 'pending',
                                'success' => 'active',
                                'danger' => 'rejected',
                            ]),
                        TextEntry::make('log_user_id')
                            ->label('ID Akun'),
                    ])
                    ->columns(2),

                Section::make('Informasi Sistem')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat')
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->label('Diupdate')
                            ->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
