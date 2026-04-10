<?php

namespace App\Filament\Widgets;

use App\Models\Materi;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseTableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class RecentMateri extends BaseTableWidget
{
    protected int|string|array $columnSpan = 'full';

    protected int $recordsPerPage = 5;

    protected function getTableHeading(): ?string
    {
        return 'Materi terbaru';
    }

    protected function getTableQuery(): Builder
    {
        return Materi::query()
            ->with('subProgram')
            ->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('judul')
                ->label('Judul')
                ->searchable()
                ->limit(40)
                ->description(fn ($record) => $record->deskripsi ? Str::limit($record->deskripsi, 60) : null),

            Tables\Columns\TextColumn::make('subProgram.name')
                ->label('Sub Program')
                ->badge()
                ->color('primary')
                ->sortable(),

            Tables\Columns\TextColumn::make('urutan')
                ->label('Pertemuan')
                ->alignRight()
                ->sortable(),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Diperbarui')
                ->since(),
        ];
    }
}
