<?php

namespace App\Filament\Resources\Pesertas\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;

use Filament\Tables\Table;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachBulkAction;

class SubProgramsRelationManager extends RelationManager
{
    protected static string $relationship = 'subPrograms';

    protected static ?string $title =
        'Kelas yang Diikuti';

    public function table(Table $table): Table
    {
        return $table

            ->recordTitleAttribute('name')

            ->columns([

                /*
                |--------------------------------------------------------------------------
                | IMAGE
                |--------------------------------------------------------------------------
                */

                ImageColumn::make('image_url')

                    ->label('Gambar')

                    ->square()

                    ->size(60)

                    ->defaultImageUrl(
                        'https://placehold.co/100x100'
                    ),

                /*
                |--------------------------------------------------------------------------
                | NAMA KELAS
                |--------------------------------------------------------------------------
                */

                TextColumn::make('name')

                    ->label('Nama Kelas')

                    ->searchable()

                    ->sortable()

                    ->weight('bold'),

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
                | DESKRIPSI
                |--------------------------------------------------------------------------
                */

                TextColumn::make('description')

                    ->label('Deskripsi')

                    ->limit(40)

                    ->wrap(),

                /*
                |--------------------------------------------------------------------------
                | TANGGAL DAFTAR
                |--------------------------------------------------------------------------
                */

                TextColumn::make('pivot.created_at')

                    ->label('Tanggal Daftar')

                    ->dateTime(),

                /*
                |--------------------------------------------------------------------------
                | PROGRESS
                |--------------------------------------------------------------------------
                */

                TextColumn::make('progress')

                    ->label('Progress')

                    ->badge()

                    ->color(fn ($state) => match (true) {

                        $state >= 100 => 'success',

                        $state >= 50 => 'warning',

                        default => 'gray',

                    })

                    ->getStateUsing(
                        fn ($record, $livewire) =>

                            $livewire
                                ->ownerRecord
                                ->getProgressBySubProgram(
                                    $record->id
                                ) . '%'
                    ),

                /*
                |--------------------------------------------------------------------------
                | STATUS
                |--------------------------------------------------------------------------
                */

                TextColumn::make('status')

                    ->label('Status')

                    ->badge()

                    ->color(fn ($state) =>

                        $state === 'Selesai'
                            ? 'success'
                            : 'warning'
                    )

                    ->getStateUsing(
                        fn ($record, $livewire) =>

                            $livewire
                                ->ownerRecord
                                ->isSubProgramCompleted(
                                    $record->id
                                )

                                ? 'Selesai'

                                : 'Proses'
                    ),

            ])

            ->recordActions([

                /*
                |--------------------------------------------------------------------------
                | DETACH
                |--------------------------------------------------------------------------
                */

                DetachAction::make()

                    ->label('Keluar Kelas'),

            ])

            ->toolbarActions([

                BulkActionGroup::make([

                    DetachBulkAction::make(),

                ]),

            ])

            ->headerActions([

                /*
                |--------------------------------------------------------------------------
                | ATTACH
                |--------------------------------------------------------------------------
                */

                AttachAction::make()

                    ->label('Tambah Kelas')

                    ->preloadRecordSelect()

                    ->after(function (
                        $record,
                        $livewire
                    ) {

                        $peserta =
                            $livewire->ownerRecord;

                        /*
                        |--------------------------------------------------------------------------
                        | AMBIL MATERI
                        |--------------------------------------------------------------------------
                        */

                        $materis =
                            $record->materis;

                        foreach (
                            $materis as $materi
                        ) {

                            /*
                            |--------------------------------------------------------------------------
                            | CEK DUPLIKAT
                            |--------------------------------------------------------------------------
                            */

                            if (
                                ! $peserta
                                    ->materis()
                                    ->where(
                                        'materi_id',
                                        $materi->id
                                    )
                                    ->exists()
                            ) {

                                $peserta
                                    ->materis()
                                    ->attach(

                                        $materi->id,

                                        [

                                            'status' =>
                                                'proses',

                                            'tanggal' =>
                                                now(),

                                        ]
                                    );
                            }
                        }
                    }),

            ]);
    }
}
