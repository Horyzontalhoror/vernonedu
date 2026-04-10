<?php

namespace App\Filament\Resources\Instrukturs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InstruktursTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->searchable(),

                TextColumn::make('no_telepon')
                    ->label('No Telepon')
                    ->icon('heroicon-o-phone')
                    ->copyable(),

                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(30),
            ])

            ->filters([
                //
            ])

            // ✅ ACTION PER BARIS (v5)
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])

            // ✅ ACTION DI ATAS TABLE (bulk)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
