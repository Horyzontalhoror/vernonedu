<?php

namespace App\Filament\Resources\LogUsers\Tables;

use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class LogUsersTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([

                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('no_telepon')
                    ->label('No. Telepon')
                    ->copyable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(
                        fn (string $state): string => match ($state) {

                            'pending' => 'warning',
                            'active' => 'success',
                            'rejected' => 'danger',

                            default => 'gray',
                        }
                    ),

            ])

            ->filters([

                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'rejected' => 'Rejected',
                    ]),

            ])

            ->actions([

                /*
                |--------------------------------------------------------------------------
                | APPROVE
                |--------------------------------------------------------------------------
                */

                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()

                    ->visible(
                        fn ($record) =>
                            $record->status === 'pending'
                    )

                    ->action(function ($record) {

                        try {

                            DB::transaction(function () use ($record) {

                                /*
                                |--------------------------------------------------------------------------
                                | UPDATE STATUS USER
                                |--------------------------------------------------------------------------
                                */

                                $record->update([
                                    'status' => 'active',
                                ]);

                                /*
                                |--------------------------------------------------------------------------
                                | CREATE PESERTA
                                |--------------------------------------------------------------------------
                                */

                                $record->peserta()->firstOrCreate(

                                    [
                                        'log_user_id' => $record->id,
                                    ],

                                    [
                                        'status' => 'active',
                                        'jenis_kelamin' => null,
                                        'tanggal_lahir' => null,
                                        'alamat' => null,
                                    ]
                                );
                            });

                            Notification::make()
                                ->title('Berhasil Disetujui')
                                ->body(
                                    "User {$record->nama} berhasil di-approve."
                                )
                                ->success()
                                ->send();

                        } catch (\Throwable $e) {

                            Notification::make()
                                ->title('Gagal Approve')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                /*
                |--------------------------------------------------------------------------
                | REJECT
                |--------------------------------------------------------------------------
                */

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()

                    ->visible(
                        fn ($record) =>
                            $record->status === 'pending'
                    )

                    ->action(function ($record) {

                        try {

                            $record->update([
                                'status' => 'rejected',
                            ]);

                            Notification::make()
                                ->title('User Ditolak')
                                ->body(
                                    "User {$record->nama} telah ditolak."
                                )
                                ->danger()
                                ->send();

                        } catch (\Throwable $e) {

                            Notification::make()
                                ->title('Gagal Reject')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

            ])

            ->bulkActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make(),

                ]),

            ]);
    }
}
