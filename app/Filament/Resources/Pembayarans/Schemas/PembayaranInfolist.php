<?php

namespace App\Filament\Resources\Pembayarans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PembayaranInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Pembayaran')
                    ->schema([

                        // 🔥 DEBUG (boleh dihapus nanti)
                        TextEntry::make('debug')
                            ->formatStateUsing(function ($state, $record) {
                                // dd($record->toArray());
                                return '';
                            }),

                        // 🔥 Nama dari log_users
                        TextEntry::make('logUser.nama')
                            ->label('Peserta')
                            ->default('-'),

                        TextEntry::make('subProgram.name')
                            ->label('Kelas')
                            ->default('-'),

                        // 🔥 dari transactions
                        TextEntry::make('jumlah')
                            ->label('Jumlah')
                            ->money('IDR'),

                        TextEntry::make('metode')
                            ->label('Metode'),

                        TextEntry::make('status')
                            ->label('Status'),

                        TextEntry::make('tanggal')
                            ->label('Tanggal')
                            ->dateTime(),

                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),

                    ])
                    ->columns(2),
            ]);
    }
}
