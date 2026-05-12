<?php

namespace App\Filament\Resources\Pesertas\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Resources\RelationManagers\RelationManager;

use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

use Filament\Forms\Components\Select;

use Filament\Actions\Action;

class MaterisRelationManager extends RelationManager
{
    protected static string $relationship = 'materis';

    protected static ?string $title =
        'Progress Materi';

    public function table(Table $table): Table
    {
        return $table

            ->recordTitleAttribute('judul')

            ->columns([

                /*
                |--------------------------------------------------------------------------
                | JUDUL
                |--------------------------------------------------------------------------
                */

                TextColumn::make('judul')

                    ->label('Materi')

                    ->searchable()

                    ->sortable()

                    ->weight('bold'),

                /*
                |--------------------------------------------------------------------------
                | KELAS
                |--------------------------------------------------------------------------
                */

                TextColumn::make('subProgram.name')

                    ->label('Kelas')
                    ->searchable()

                    ->sortable()

                    ->badge()

                    ->color('info'),

                /*
                |--------------------------------------------------------------------------
                | STATUS
                |--------------------------------------------------------------------------
                */

                TextColumn::make('pivot.status')

                    ->label('Status')

                    ->badge()

                    ->color(fn ($state) => match ($state) {

                        'selesai' => 'success',

                        'proses' => 'warning',

                        default => 'gray',
                    })

                    ->formatStateUsing(
                        fn ($state) => match ($state) {

                            'selesai' => 'Selesai',

                            'proses' => 'Proses',

                            default => ucfirst($state),
                        }
                    ),

                /*
                |--------------------------------------------------------------------------
                | TANGGAL
                |--------------------------------------------------------------------------
                */

                TextColumn::make('pivot.tanggal')

                    ->label('Tanggal Progress')

                    ->date(),

            ])

            /*
            |--------------------------------------------------------------------------
            | HEADER ACTION
            |--------------------------------------------------------------------------
            */

            ->headerActions([

                AttachAction::make()

                    ->label('Tambah Progress')

                    ->preloadRecordSelect()

                    ->form([

                        Select::make('status')

                            ->label('Status Progress')

                            ->options([

                                'proses' =>
                                    '🟡 Proses',

                                'selesai' =>
                                    '🟢 Selesai',

                            ])

                            ->native(false)

                            ->required(),

                    ])

                    ->mutateFormDataUsing(function (
                        array $data
                    ) {

                        $data['tanggal'] = now();

                        return $data;
                    }),

            ])

            /*
            |--------------------------------------------------------------------------
            | FILTER QUERY
            |--------------------------------------------------------------------------
            */

            ->modifyQueryUsing(function (
                $query,
                $livewire
            ) {

                $peserta =
                    $livewire->ownerRecord;

                /*
                |--------------------------------------------------------------------------
                | SEMUA KELAS YANG DIIKUTI
                |--------------------------------------------------------------------------
                */

                $subProgramIds = $peserta

                    ->subPrograms()

                    ->pluck(
                        'sub_programs.id'
                    );

                /*
                |--------------------------------------------------------------------------
                | FILTER MATERI
                |--------------------------------------------------------------------------
                */

                return $query->where(function ($q)

                    use (
                        $peserta,
                        $subProgramIds
                    ) {

                    foreach (
                        $subProgramIds
                        as $subProgramId
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | MATERI TERAKHIR SELESAI
                        |--------------------------------------------------------------------------
                        */

                        $lastCompleted = $peserta

                            ->materis()

                            ->wherePivot(
                                'status',
                                'selesai'
                            )

                            ->whereHas(

                                'subProgram',

                                fn ($sub) =>

                                    $sub->where(
                                        'id',
                                        $subProgramId
                                    )
                            )

                            ->orderByDesc(
                                'urutan'
                            )

                            ->first();

                        /*
                        |--------------------------------------------------------------------------
                        | BELUM ADA PROGRESS
                        |--------------------------------------------------------------------------
                        */

                        if (! $lastCompleted) {

                            $q->orWhere(function (
                                $sub
                            ) use (
                                $subProgramId
                            ) {

                                $sub

                                    ->where(
                                        'sub_program_id',
                                        $subProgramId
                                    )

                                    ->where(
                                        'urutan',
                                        1
                                    );
                            });

                            continue;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | NEXT MATERI
                        |--------------------------------------------------------------------------
                        */

                        $nextUrutan =
                            $lastCompleted->urutan + 1;

                        $q->orWhere(function ($sub)

                            use (
                                $subProgramId,
                                $nextUrutan
                            ) {

                            $sub

                                ->where(
                                    'sub_program_id',
                                    $subProgramId
                                )

                                ->where(
                                    'urutan',
                                    '<=',
                                    $nextUrutan
                                );
                        });
                    }
                });
            })

            /*
            |--------------------------------------------------------------------------
            | RECORD ACTIONS
            |--------------------------------------------------------------------------
            */

            ->recordActions([

                Action::make('selesai')

                    ->label('Tandai Selesai')

                    ->color('success')

                    ->icon('heroicon-m-check-circle')

                    ->requiresConfirmation()

                    ->action(function (
                        $record,
                        $livewire
                    ) {

                        $peserta =
                            $livewire->ownerRecord;

                        /*
                        |--------------------------------------------------------------------------
                        | UPDATE PROGRESS
                        |--------------------------------------------------------------------------
                        */

                        $peserta
                            ->materis()
                            ->updateExistingPivot(

                                $record->id,

                                [

                                    'status' =>
                                        'selesai',

                                    'tanggal' =>
                                        now(),

                                ]
                            );

                        /*
                        |--------------------------------------------------------------------------
                        | AUTO CERTIFICATE
                        |--------------------------------------------------------------------------
                        */

                        if (

                            $peserta
                                ->isSubProgramCompleted(
                                    $record->sub_program_id
                                )

                        ) {

                            \App\Models\Certificate::firstOrCreate([

                                'peserta_id' =>
                                    $peserta->id,

                                'sub_program_id' =>
                                    $record->sub_program_id,

                            ]);
                        }
                    }),

            ]);
    }
}
