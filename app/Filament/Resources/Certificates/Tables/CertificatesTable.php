<?php

namespace App\Filament\Resources\Certificates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class CertificatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('peserta.nama')
                    ->label('Nama Peserta')
                    ->searchable()
                    ->description(fn ($record) => $record->peserta?->email),

                TextColumn::make('subProgram.name')
                    ->label('Sub Program')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status Sertifikat')
                    ->badge()
                    ->sortable(),

                TextColumn::make('kelayakan')
                    ->label('Kelayakan')
                    ->badge()
                    ->color(fn ($state) => $state === 'Layak' ? 'success' : 'warning')
                    ->getStateUsing(function ($record) {
                        return $record->peserta
                            ->isSubProgramCompleted($record->sub_program_id)
                            ? 'Layak'
                            : 'Belum';
                    }),

                TextColumn::make('file_url')
                    ->label('Link Sertifikat')
                    ->url(fn ($record) => $record->file_url)
                    ->openUrlInNewTab()
                    ->limit(30)
                    ->placeholder('Belum diisi'),

                TextColumn::make('issued_at')
                    ->label('Tanggal Terbit')
                    ->dateTime('d M Y H:i')
                    ->placeholder('Belum diterbitkan'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
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
