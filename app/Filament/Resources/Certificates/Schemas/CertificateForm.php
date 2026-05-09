<?php

namespace App\Filament\Resources\Certificates\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CertificateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema

            ->components([

                /*
                |--------------------------------------------------------------------------
                | INFORMASI SERTIFIKAT
                |--------------------------------------------------------------------------
                */

                Section::make('Informasi Sertifikat')

                    ->schema([

                        /*
                        |--------------------------------------------------------------------------
                        | ID
                        |--------------------------------------------------------------------------
                        */

                        Placeholder::make('id')

                            ->label('ID')

                            ->content(
                                fn ($record) =>
                                    $record?->id ?? '-'
                            )

                            ->hidden(
                                fn ($record) =>
                                    $record === null
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | PESERTA
                        |--------------------------------------------------------------------------
                        */

                        Select::make('peserta_id')

                            ->label('Peserta')

                            ->relationship(
                                'peserta',
                                'id'
                            )

                            ->searchable()

                            ->preload()

                            ->getOptionLabelFromRecordUsing(
                                fn ($record) =>

                                    ($record->nama ?? '-') .

                                    ' • ' .

                                    ($record->email ?? '-')
                            )

                            ->required(),

                        /*
                        |--------------------------------------------------------------------------
                        | SUB PROGRAM
                        |--------------------------------------------------------------------------
                        */

                        Select::make('sub_program_id')

                            ->label('Sub Program')

                            ->relationship(
                                'subProgram',
                                'name'
                            )

                            ->searchable()

                            ->preload()

                            ->required(),

                        /*
                        |--------------------------------------------------------------------------
                        | STATUS
                        |--------------------------------------------------------------------------
                        */

                        Select::make('status')

                            ->label('Status Sertifikat')

                            ->options([

                                'draft' =>
                                    'Draft',

                                'published' =>
                                    'Published',

                                'revoked' =>
                                    'Revoked',

                            ])

                            ->default('draft')

                            ->required(),

                        /*
                        |--------------------------------------------------------------------------
                        | KELAYAKAN
                        |--------------------------------------------------------------------------
                        */

                        Placeholder::make('kelayakan')

                            ->label('Kelayakan')

                            ->content(function ($record) {

                                if (
                                    ! $record ||
                                    ! $record->peserta
                                ) {

                                    return '-';

                                }

                                return $record->peserta
                                    ->isSubProgramCompleted(
                                        $record->sub_program_id
                                    )

                                    ? 'Layak Mendapat Sertifikat'

                                    : 'Belum Menyelesaikan Program';
                            })

                            ->hidden(
                                fn ($record) =>
                                    $record === null
                            ),

                    ])

                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | DOKUMEN
                |--------------------------------------------------------------------------
                */

                Section::make('Dokumen Sertifikat')

                    ->schema([

                        /*
                        |--------------------------------------------------------------------------
                        | FILE UPLOAD
                        |--------------------------------------------------------------------------
                        */

                        FileUpload::make('file_path')

                            ->label('Upload Sertifikat')

                            ->directory('certificates')

                            ->downloadable()

                            ->openable()

                            ->previewable()

                            ->acceptedFileTypes([
                                'application/pdf',
                                'image/png',
                                'image/jpeg',
                            ])

                            ->maxSize(10240),

                        /*
                        |--------------------------------------------------------------------------
                        | FILE URL
                        |--------------------------------------------------------------------------
                        */

                        TextInput::make('file_url')

                            ->label('Link Sertifikat')

                            ->url()

                            ->placeholder(
                                'https://example.com/certificate.pdf'
                            ),

                    ])

                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | TIMELINE
                |--------------------------------------------------------------------------
                */

                Section::make('Timeline')

                    ->schema([

                        /*
                        |--------------------------------------------------------------------------
                        | ISSUED AT
                        |--------------------------------------------------------------------------
                        */

                        DateTimePicker::make('issued_at')

                            ->label('Tanggal Terbit')

                            ->seconds(false),

                        /*
                        |--------------------------------------------------------------------------
                        | CREATED AT
                        |--------------------------------------------------------------------------
                        */

                        Placeholder::make('created_at')

                            ->label('Dibuat')

                            ->content(
                                fn ($record) =>

                                    $record?->created_at
                                        ?->format('d M Y H:i')

                                    ?? '-'
                            )

                            ->hidden(
                                fn ($record) =>
                                    $record === null
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | UPDATED AT
                        |--------------------------------------------------------------------------
                        */

                        Placeholder::make('updated_at')

                            ->label('Diperbarui')

                            ->content(
                                fn ($record) =>

                                    $record?->updated_at
                                        ?->format('d M Y H:i')

                                    ?? '-'
                            )

                            ->hidden(
                                fn ($record) =>
                                    $record === null
                            ),

                    ])

                    ->columns(2),

            ]);
    }
}
