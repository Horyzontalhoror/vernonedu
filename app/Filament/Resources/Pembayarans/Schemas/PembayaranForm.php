<?php

namespace App\Filament\Resources\Pembayarans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PembayaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema

            ->components([

                Section::make('Data Transaksi')

                    ->schema([

                        /*
                        |--------------------------------------------------------------------------
                        | USER
                        |--------------------------------------------------------------------------
                        */

                        Select::make('user_id')
                            ->label('Peserta')

                            ->relationship(
                                'user',
                                'nama'
                            )

                            ->searchable([
                                'nama',
                                'email',
                                'no_telepon',
                            ])

                            ->preload()
                            ->required(),

                        /*
                        |--------------------------------------------------------------------------
                        | SUB PROGRAM
                        |--------------------------------------------------------------------------
                        */

                        Select::make('sub_program_id')
                            ->label('Kelas')

                            ->relationship(
                                'subProgram',
                                'name'
                            )

                            ->searchable()
                            ->preload()
                            ->required(),

                        /*
                        |--------------------------------------------------------------------------
                        | ORDER ID
                        |--------------------------------------------------------------------------
                        */

                        TextInput::make('order_id')
                            ->label('Order ID')
                            ->disabled(),

                        /*
                        |--------------------------------------------------------------------------
                        | AMOUNT
                        |--------------------------------------------------------------------------
                        */

                        TextInput::make('amount')
                            ->label('Nominal')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),

                        /*
                        |--------------------------------------------------------------------------
                        | SNAP TOKEN
                        |--------------------------------------------------------------------------
                        */

                        TextInput::make('snap_token')
                            ->label('Snap Token')
                            ->disabled()
                            ->columnSpanFull(),

                        /*
                        |--------------------------------------------------------------------------
                        | PAYMENT TYPE
                        |--------------------------------------------------------------------------
                        */

                        Select::make('payment_type')
                            ->label('Metode Pembayaran')

                            ->options([

                                'bank_transfer' =>
                                    'Bank Transfer',

                                'gopay' =>
                                    'GoPay',

                                'shopeepay' =>
                                    'ShopeePay',

                                'qris' =>
                                    'QRIS',

                                'credit_card' =>
                                    'Credit Card',

                            ])

                            ->placeholder('Belum dibayar'),

                        /*
                        |--------------------------------------------------------------------------
                        | TRANSACTION STATUS
                        |--------------------------------------------------------------------------
                        */

                        Select::make('transaction_status')
                            ->label('Status')

                            ->options([

                                'pending' =>
                                    'Pending',

                                'settlement' =>
                                    'Settlement',

                                'capture' =>
                                    'Capture',

                                'deny' =>
                                    'Deny',

                                'cancel' =>
                                    'Cancel',

                                'expire' =>
                                    'Expire',

                            ])

                            ->required(),

                    ])

                    ->columns(2),

            ]);
    }
}
