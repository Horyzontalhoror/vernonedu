<?php

namespace App\Filament\Resources\Pembayarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class PembayaransTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([

                /*
                |--------------------------------------------------------------------------
                | ORDER ID
                |--------------------------------------------------------------------------
                */

                TextColumn::make('order_id')
                    ->label('Order ID')
                    ->searchable()
                    ->copyable()
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | PESERTA
                |--------------------------------------------------------------------------
                */

                TextColumn::make('user.nama')
                    ->label('Peserta')
                    ->searchable()
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | SUB PROGRAM
                |--------------------------------------------------------------------------
                */

                TextColumn::make('subProgram.name')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | AMOUNT
                |--------------------------------------------------------------------------
                */

                TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | PAYMENT TYPE
                |--------------------------------------------------------------------------
                */

                SelectColumn::make('payment_type')

                    ->label('Metode')

                    ->options([

                        'bank_transfer' => 'Bank Transfer',

                        'gopay' => 'GoPay',

                        'qris' => 'QRIS',

                        'shopeepay' => 'ShopeePay',

                        'credit_card' => 'Credit Card',

                    ])

                    ->selectablePlaceholder(false)

                    ->placeholder('-'),

                /*
                |--------------------------------------------------------------------------
                | TRANSACTION STATUS
                |--------------------------------------------------------------------------
                */

                SelectColumn::make('transaction_status')

                    ->label('Status')

                    ->options([

                        'pending' => 'Pending',

                        'settlement' => 'Settlement',

                        'capture' => 'Capture',

                        'deny' => 'Denied',

                        'cancel' => 'Cancelled',

                        'expire' => 'Expired',

                    ])

                    ->selectablePlaceholder(false),

                /*
                |--------------------------------------------------------------------------
                | CREATED AT
                |--------------------------------------------------------------------------
                */

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('updated_at')
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

            ])

            ->defaultSort('created_at', 'desc');
    }
}
