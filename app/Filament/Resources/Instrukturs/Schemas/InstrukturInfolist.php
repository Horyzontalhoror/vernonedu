<?php

namespace App\Filament\Resources\Instrukturs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class InstrukturInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profil Instruktur')
                    ->description('Detail informasi instruktur')
                    ->schema([
                        TextEntry::make('nama')
                            ->label('Nama Instruktur'),

                        TextEntry::make('jabatan')
                            ->label('Jabatan'),

                        TextEntry::make('no_telepon')
                            ->label('No Telepon')
                            ->icon('heroicon-o-phone'),

                        TextEntry::make('alamat')
                            ->label('Alamat')
                            ->columnSpanFull()
                            ->wrap(),
                    ])
                    ->columns(2),
            ]);
    }
}
