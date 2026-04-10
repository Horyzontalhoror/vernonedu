<?php

namespace App\Filament\Resources\SubPrograms\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Schemas\Schema;
use App\Filament\Resources\Materis\Schemas\MateriForm;

class MaterisRelationManager extends RelationManager
{
    protected static string $relationship = 'materis';

    protected static ?string $title = 'Daftar Materi';

    // HUBUNGKAN FORM
    public function form(Schema $schema): Schema
    {
        return MateriForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('judul')
            ->columns([
                TextColumn::make('urutan')
                    ->label('Pertemuan')
                    ->sortable(),

                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable(),

                TextColumn::make('deskripsi')
                    ->limit(50),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Dibuat'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Materi'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
