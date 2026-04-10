<?php

namespace App\Filament\Resources\Materis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class MaterisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('urutan')
                    ->label('Pertemuan')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('subProgram.name')
                    ->label('Sub Program')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable(),

                TextColumn::make('deskripsi')
                    ->limit(40),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
