<?php

namespace App\Filament\Resources\Pesertas\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachBulkAction;

class SubProgramsRelationManager extends RelationManager
{
    protected static string $relationship = 'subPrograms';

    protected static ?string $title = 'Kelas yang Diikuti';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Kelas')
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(40),

                TextColumn::make('pivot.created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime(),
                TextColumn::make('progress')
                    ->label('Progress')
                    ->getStateUsing(fn ($record, $livewire) =>
                        $livewire->ownerRecord->getProgressBySubProgram($record->id) . '%'
                    ),
                TextColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(fn ($record, $livewire) =>
                        $livewire->ownerRecord->isSubProgramCompleted($record->id)
                            ? 'Selesai'
                            : 'Proses'
                    ),
            ])
            ->recordActions([
                DetachAction::make()
                    ->label('Keluar dari Kelas'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Tambah Kelas')
                    ->preloadRecordSelect()
                    ->after(function ($record, $livewire) {
                        $peserta = $livewire->ownerRecord;

                        // ambil semua materi dari subprogram
                        $materis = $record->materis;

                        foreach ($materis as $materi) {
                            if (! $peserta->materis->contains($materi->id)) {
                                $peserta->materis()->attach($materi->id, [
                                    'status' => 'proses',
                                    'tanggal' => now(),
                                ]);
                            }
                        }
                    }),
            ]);
    }
}
