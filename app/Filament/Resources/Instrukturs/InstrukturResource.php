<?php

namespace App\Filament\Resources\Instrukturs;

use App\Filament\Resources\Instrukturs\Pages\CreateInstruktur;
use App\Filament\Resources\Instrukturs\Pages\EditInstruktur;
use App\Filament\Resources\Instrukturs\Pages\ListInstrukturs;
use App\Filament\Resources\Instrukturs\Pages\ViewInstruktur;
use App\Filament\Resources\Instrukturs\Schemas\InstrukturForm;
use App\Filament\Resources\Instrukturs\Schemas\InstrukturInfolist;
use App\Filament\Resources\Instrukturs\Tables\InstruktursTable;
use App\Models\Instruktur;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InstrukturResource extends Resource
{
    protected static ?string $model = Instruktur::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;
    protected static string |BackedEnum|null $activeNavigationIcon = Heroicon::OutlinedArrowDownRight;
    protected static string | UnitEnum | null $navigationGroup = 'Manajemen Kelas';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Instruktur';

    public static function form(Schema $schema): Schema
    {
        return InstrukturForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InstrukturInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InstruktursTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInstrukturs::route('/'),
            'create' => CreateInstruktur::route('/create'),
            'view' => ViewInstruktur::route('/{record}'),
            'edit' => EditInstruktur::route('/{record}/edit'),
        ];
    }
}
