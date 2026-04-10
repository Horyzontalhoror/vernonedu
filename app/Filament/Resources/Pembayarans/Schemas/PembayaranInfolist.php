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
                        TextEntry::make('peserta.nama')
                            ->label('Peserta'),

                        TextEntry::make('subProgram.name')
                            ->label('Kelas'),

                        TextEntry::make('jumlah')
                            ->money('IDR'),

                        TextEntry::make('tanggal')
                            ->date(),

                        TextEntry::make('metode'),

                        TextEntry::make('status'),

                        TextEntry::make('keterangan')
                            ->columnSpanFull()
                            ->wrap(),
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
