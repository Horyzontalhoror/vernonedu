<?php

namespace App\Filament\Resources\Materis\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\Action;
use App\Models\Peserta;

class PesertasRelationManager extends RelationManager
{
    protected static string $relationship = 'pesertas';

    protected static ?string $title = 'Progress Peserta';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                TextColumn::make('nama')
                    ->label('Peserta')
                    ->searchable(),

                TextColumn::make('pivot.status')
                    ->label('Status')
                    ->badge(),

                TextColumn::make('pivot.tanggal')
                    ->label('Tanggal')
                    ->date(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Tambah Peserta')
                    ->recordSelect(function ($select) {
                        return $select
                            ->relationship(
                                name: 'pesertas',
                                titleAttribute: 'nama',
                                modifyQueryUsing: function ($query) {
                                    $query->whereHas('subPrograms', function ($q) {
                                        $q->where('sub_programs.id', $this->getOwnerRecord()->sub_program_id);
                                    });
                                }
                            )
                            ->searchable()
                            ->preload();
                    })
                    ->form([
                        Select::make('status')
                            ->options([
                                'hadir' => 'Hadir',
                                'izin' => 'Izin',
                                'sakit' => 'Sakit',
                                'tidak_hadir' => 'Tidak Hadir',
                            ])
                            ->required(),
                    ]),
            ])
            ->recordActions([

                DetachAction::make(),
            ])
            ->headerActions([
                Action::make('generatePeserta')
                    ->label('Generate Peserta')
                    ->action(function () {
                        $materi = $this->getOwnerRecord();

                        $pesertas = Peserta::whereHas('subPrograms', function ($q) use ($materi) {
                            $q->where('sub_programs.id', $materi->sub_program_id);
                        })->get();

                        foreach ($pesertas as $peserta) {
                            $materi->pesertas()->syncWithoutDetaching([
                                $peserta->id => [
                                    'status' => 'tidak_hadir',
                                    'tanggal' => now(),
                                ],
                            ]);
                        }
                    })
                    ->requiresConfirmation()
                    ->color('success'),
            ]);
    }
}
