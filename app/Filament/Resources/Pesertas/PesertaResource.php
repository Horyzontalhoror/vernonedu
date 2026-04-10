<?php

namespace App\Filament\Resources\Pesertas;

use App\Filament\Resources\Pesertas\Pages\CreatePeserta;
use App\Filament\Resources\Pesertas\Pages\EditPeserta;
use App\Filament\Resources\Pesertas\Pages\ListPesertas;
use App\Filament\Resources\Pesertas\Pages\ViewPeserta;
use App\Filament\Resources\Pesertas\RelationManagers\MaterisRelationManager;
use App\Filament\Resources\Pesertas\RelationManagers\SubProgramsRelationManager;
use App\Filament\Resources\Pesertas\Schemas\PesertaForm;
use App\Filament\Resources\Pesertas\Schemas\PesertaInfolist;
use App\Filament\Resources\Pesertas\Tables\PesertasTable;
use App\Models\Peserta;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PesertaResource extends Resource
{
    protected static ?string $model = Peserta::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::OutlinedArrowDownRight;

    protected static ?string $navigationLabel = 'Peserta';
    protected static ?int $navigationSort = 1;
    protected static string|UnitEnum|null $navigationGroup = 'Peserta & Akun';

    public static function form(Schema $schema): Schema
    {
        return PesertaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PesertaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PesertasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            SubProgramsRelationManager::class,
            MaterisRelationManager::class,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('logUser', fn (Builder $query) => $query->where('status', 'active'));
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPesertas::route('/'),
            'create' => CreatePeserta::route('/create'),
            'view' => ViewPeserta::route('/{record}'),
            'edit' => EditPeserta::route('/{record}/edit'),
        ];
    }
}
