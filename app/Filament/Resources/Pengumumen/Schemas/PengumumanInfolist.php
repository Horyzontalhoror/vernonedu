<?php

namespace App\Filament\Resources\Pengumumen\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class PengumumanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Pengumuman')
                    ->schema([
                        TextEntry::make('judul'),

                        TextEntry::make('tipe'),

                        TextEntry::make('tanggal')
                            ->date(),

                        TextEntry::make('status'),

                        TextEntry::make('isi')
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
