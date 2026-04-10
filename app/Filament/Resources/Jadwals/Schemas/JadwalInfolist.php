<?php

namespace App\Filament\Resources\Jadwals\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class JadwalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Jadwal')
                    ->schema([
                        TextEntry::make('subProgram.name')
                            ->label('Sub Program'),

                        TextEntry::make('instruktur.nama')
                            ->label('Instruktur'),

                        TextEntry::make('tanggal')
                            ->date(),

                        TextEntry::make('waktu_mulai')
                            ->label('Mulai'),

                        TextEntry::make('waktu_selesai')
                            ->label('Selesai'),

                        TextEntry::make('lokasi'),

                        TextEntry::make('status'),

                        TextEntry::make('keterangan')
                            ->columnSpanFull()
                            ->wrap(),
                        ])
                    ->columns(2),
            ]);
    }
}
