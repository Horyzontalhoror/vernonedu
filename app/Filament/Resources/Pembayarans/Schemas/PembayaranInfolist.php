<?php

namespace App\Filament\Resources\Pembayarans\Schemas;

use Filament\Infolists\Components\TextEntry;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PembayaranInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema

            ->components([

                Section::make('Detail Transaksi')

                    ->schema([

                        /*
                        |--------------------------------------------------------------------------
                        | USER
                        |--------------------------------------------------------------------------
                        */

                        TextEntry::make('user.nama')
                            ->label('Peserta')
                            ->default('-'),

                        /*
                        |--------------------------------------------------------------------------
                        | SUB PROGRAM
                        |--------------------------------------------------------------------------
                        */

                        TextEntry::make('subProgram.name')
                            ->label('Kelas')
                            ->default('-'),

                        /*
                        |--------------------------------------------------------------------------
                        | ORDER ID
                        |--------------------------------------------------------------------------
                        */

                        TextEntry::make('order_id')
                            ->label('Order ID')
                            ->copyable(),

                        /*
                        |--------------------------------------------------------------------------
                        | AMOUNT
                        |--------------------------------------------------------------------------
                        */

                        TextEntry::make('amount')
                            ->label('Nominal')
                            ->money('IDR'),

                        /*
                        |--------------------------------------------------------------------------
                        | PAYMENT TYPE
                        |--------------------------------------------------------------------------
                        */

                        TextEntry::make('payment_type')
                            ->label('Metode Pembayaran')
                            ->placeholder('-'),

                        /*
                        |--------------------------------------------------------------------------
                        | TRANSACTION STATUS
                        |--------------------------------------------------------------------------
                        */

                        TextEntry::make('transaction_status')
                            ->label('Status')
                            ->badge()
                            ->color(
                                fn (string $state): string => match ($state) {

                                    'pending' => 'warning',

                                    'settlement' => 'success',
                                    'capture' => 'success',

                                    'deny' => 'danger',
                                    'cancel' => 'danger',

                                    'expire' => 'gray',

                                    default => 'gray',
                                }
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | SNAP TOKEN
                        |--------------------------------------------------------------------------
                        */

                        TextEntry::make('snap_token')
                            ->label('Snap Token')
                            ->placeholder('-')
                            ->columnSpanFull(),

                        /*
                        |--------------------------------------------------------------------------
                        | CREATED
                        |--------------------------------------------------------------------------
                        */

                        TextEntry::make('created_at')
                            ->label('Dibuat')
                            ->dateTime('d M Y H:i'),

                        TextEntry::make('updated_at')
                            ->label('Diupdate')
                            ->dateTime('d M Y H:i'),

                    ])

                    ->columns(2),

            ]);
    }
}
