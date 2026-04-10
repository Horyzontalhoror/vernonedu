<?php

namespace App\Filament\Resources\Pesertas\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Actions\Action;

class MaterisRelationManager extends RelationManager
{
    protected static string $relationship = 'materis';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('judul')
            ->columns([
                TextColumn::make('judul'),

                TextColumn::make('subProgram.name')
                    ->label('Kelas'),

                TextColumn::make('pivot.status')
                    ->label('Status'),

                TextColumn::make('pivot.tanggal')
                    ->date(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Ambil Materi')
                    ->preloadRecordSelect()
                    ->form([
                        Select::make('status')
                            ->options([
                                'proses' => 'Proses',
                                'selesai' => 'Selesai',
                            ])
                            ->required(),
                    ])
                    ->mutateFormDataUsing(function (array $data) {
                        $data['tanggal'] = now();
                        return $data;
                    }),
            ])
            ->modifyQueryUsing(function ($query, $livewire) {
                $peserta = $livewire->ownerRecord;

                $lastCompleted = $peserta->materis()
                    ->wherePivot('status', 'selesai')
                    ->get()
                    ->groupBy('sub_program_id')
                    ->map(fn ($items) => $items->max('urutan'));

                return $query->where(function ($q) use ($lastCompleted) {
                    foreach ($lastCompleted as $subProgramId => $lastUrutan) {
                        $q->orWhere(function ($sub) use ($subProgramId, $lastUrutan) {
                            $sub->where('sub_program_id', $subProgramId)
                                ->where('urutan', '<=', $lastUrutan + 1);
                        });
                    }
                });
            })
            ->recordActions([
                Action::make('selesai')
                    ->label('Tandai Selesai')
                    ->action(function ($record, $livewire) {
                        $peserta = $livewire->ownerRecord;

                        // update status
                        $peserta->materis()->updateExistingPivot($record->id, [
                            'status' => 'selesai',
                            'tanggal' => now(),
                        ]);

                        // cek apakah semua selesai
                        if ($peserta->isSubProgramCompleted($record->sub_program_id)) {
                            \App\Models\Certificate::firstOrCreate([
                                'peserta_id' => $peserta->id,
                                'sub_program_id' => $record->sub_program_id,
                            ]);
                        }
                    })
            ]);
    }
}
