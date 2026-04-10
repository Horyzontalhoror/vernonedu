<?php

namespace App\Filament\Resources\Pembayarans\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PembayaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pembayaran')
                    ->schema([
                        Select::make('peserta_id')
                            ->label('Peserta')
                            ->relationship('peserta', 'email')
                            ->searchable(['email', 'logUser.nama', 'logUser.no_telepon'])
                            ->preload()
                            ->getOptionLabelFromRecordUsing(fn ($record) => ($record->logUser->nama ?? '-') . ' — ' . $record->email)
                            ->required(),

                        Select::make('sub_program_id')
                            ->label('Kelas')
                            ->relationship('subProgram', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('jumlah')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),

                        DatePicker::make('tanggal')
                            ->required(),

                        Select::make('metode')
                            ->options([
                                'transfer' => 'Transfer',
                                'cash' => 'Cash',
                                'ewallet' => 'E-Wallet',
                            ])
                            ->required(),

                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'lunas' => 'Lunas',
                                'gagal' => 'Gagal',
                            ])
                            ->default('pending')
                            ->required(),

                        Textarea::make('keterangan')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
