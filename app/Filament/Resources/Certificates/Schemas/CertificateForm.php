<?php

namespace App\Filament\Resources\Certificates\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CertificateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Sertifikat')
                    ->schema([
                        Placeholder::make('id')
                            ->label('ID')
                            ->content(fn ($record) => $record?->id ?? '-')
                            ->hidden(fn ($record) => $record === null),

                        Select::make('peserta_id')
                            ->label('Nama Peserta')
                            ->relationship('peserta', 'email')
                            ->searchable(['email', 'logUser.nama'])
                            ->preload()
                            ->getOptionLabelFromRecordUsing(fn ($record) => ($record->logUser->nama ?? '-') . ' — ' . $record->email)
                            ->required(),

                        Select::make('sub_program_id')
                            ->label('Sub Program')
                            ->relationship('subProgram', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('status')
                            ->label('Status Sertifikat')
                            ->options([
                                'draft' => 'Draft',
                                'issued' => 'Diterbitkan',
                                'revoked' => 'Dicabut',
                            ])
                            ->required()
                            ->default('draft'),

                        Placeholder::make('kelayakan')
                            ->label('Kelayakan')
                            ->content(function ($record) {
                                if (! $record || ! $record->peserta) {
                                    return '-';
                                }

                                return $record->peserta
                                    ->isSubProgramCompleted($record->sub_program_id)
                                    ? 'Layak'
                                    : 'Belum';
                            })
                            ->hidden(fn ($record) => $record === null),
                    ])
                    ->columns(2),

                Section::make('Dokumen')
                    ->schema([
                        FileUpload::make('file_path')
                            ->label('Upload Sertifikat')
                            ->image()
                            ->directory('certificates')
                            ->downloadable()
                            ->openable(),

                        TextInput::make('file_url')
                            ->label('Link Sertifikat')
                            ->url()
                            ->placeholder('https://example.com/sertifikat.pdf'),
                    ])
                    ->columns(2),

                Section::make('Timeline')
                    ->schema([
                        DateTimePicker::make('issued_at')
                            ->label('Tanggal Terbit')
                            ->seconds(false),

                        Placeholder::make('created_at')
                            ->label('Dibuat')
                            ->content(fn ($record) => $record?->created_at?->format('d M Y H:i') ?? '-')
                            ->hidden(fn ($record) => $record === null),

                        Placeholder::make('updated_at')
                            ->label('Diperbarui')
                            ->content(fn ($record) => $record?->updated_at?->format('d M Y H:i') ?? '-')
                            ->hidden(fn ($record) => $record === null),
                    ])
                    ->columns(2),
            ]);
    }
}
