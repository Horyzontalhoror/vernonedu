<?php

namespace App\Filament\Resources\Pesertas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PesertaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pribadi')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required(),

                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),

                        TextInput::make('no_telepon')
                            ->label('No Telepon')
                            ->tel()
                            ->required(),

                        Select::make('jenis_kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required(),

                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir'),

                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Akun Peserta')
                    ->schema([
                        Select::make('status')
                            ->label('Status Akun')
                            ->options([
                                'pending' => 'Pending',
                                'active' => 'Aktif',
                                'rejected' => 'Ditolak',
                            ])
                            ->default('active')
                            ->required(),

                        TextInput::make('password')
                            ->label('Password Akun')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->helperText('Kosongkan saat tidak ingin mengubah password.'),
                    ])
                    ->columns(2),
            ]);
    }
}
