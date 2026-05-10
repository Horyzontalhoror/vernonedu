<?php

namespace App\Filament\Resources\SubPrograms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Table;

class SubProgramsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([

                /*
                |--------------------------------------------------------------------------
                | IMAGE
                |--------------------------------------------------------------------------
                */

                ImageColumn::make('image_url')

                    ->label('Gambar')

                    ->square()

                    ->size(70)

                    ->defaultImageUrl(
                        url('https://placehold.co/100x100')
                    ),

                /*
                |--------------------------------------------------------------------------
                | PROGRAM
                |--------------------------------------------------------------------------
                */

                TextColumn::make('program.nama')

                    ->label('Program')

                    ->searchable()

                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | SUB PROGRAM
                |--------------------------------------------------------------------------
                */

                TextColumn::make('name')

                    ->label('Sub Program')

                    ->searchable()

                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | USIA
                |--------------------------------------------------------------------------
                */

                TextColumn::make('usia')

                    ->label('Usia')

                    ->badge()

                    ->color('info'),

                /*
                |--------------------------------------------------------------------------
                | HARGA
                |--------------------------------------------------------------------------
                */

                TextColumn::make('harga')

                    ->label('Harga')

                    ->money('IDR'),

                /*
                |--------------------------------------------------------------------------
                | DESCRIPTION
                |--------------------------------------------------------------------------
                */

                TextColumn::make('description')

                    ->label('Deskripsi')

                    ->limit(40)

                    ->wrap(),

                /*
                |--------------------------------------------------------------------------
                | CREATED
                |--------------------------------------------------------------------------
                */

                TextColumn::make('created_at')

                    ->label('Dibuat')

                    ->dateTime()

                    ->sortable()

                    ->toggleable(
                        isToggledHiddenByDefault: true
                    ),

            ])

            ->filters([

                //

            ])

            ->recordActions([

                ViewAction::make(),

                EditAction::make(),

            ])

            ->toolbarActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make(),

                ]),

            ]);
    }
}
