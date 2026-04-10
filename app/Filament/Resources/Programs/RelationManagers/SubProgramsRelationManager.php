<?php

namespace App\Filament\Resources\Programs\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Set as ComponentSet;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SubProgramsRelationManager extends RelationManager
{
    protected static string $relationship = 'subPrograms';

    protected static ?string $title = 'Sub Program';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Sub Program')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (ComponentSet $set, ?string $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),

                TextInput::make('usia')
                    ->label('Target Usia')
                    ->helperText('Contoh: 7-9 tahun'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Sub Program')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('usia')
                    ->label('Usia')
                    ->badge()
                    ->color('info'),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(60),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Sub Program'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
