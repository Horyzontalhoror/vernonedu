<?php

namespace App\Filament\Resources\SubPrograms;

use App\Filament\Resources\SubPrograms\Pages\CreateSubProgram;
use App\Filament\Resources\SubPrograms\Pages\EditSubProgram;
use App\Filament\Resources\SubPrograms\Pages\ListSubPrograms;
use App\Filament\Resources\SubPrograms\Pages\ViewSubProgram;
use App\Filament\Resources\SubPrograms\Schemas\SubProgramForm;
use App\Filament\Resources\SubPrograms\Schemas\SubProgramInfolist;
use App\Filament\Resources\SubPrograms\Tables\SubProgramsTable;
use App\Filament\Resources\SubPrograms\RelationManagers\MaterisRelationManager;
use App\Models\SubProgram;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SubProgramResource extends Resource
{
    protected static ?string $model = SubProgram::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;
    protected static string |BackedEnum|null $activeNavigationIcon = Heroicon::OutlinedArrowDownRight;

    protected static ?string $navigationLabel = 'Kelas';
    protected static ?string $pluralLabel = 'Kelas';
    protected static ?string $label = 'Kelas';

    protected static string | UnitEnum | null $navigationGroup = 'Manajemen Kelas';

    public static function form(Schema $schema): Schema
    {
        return SubProgramForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SubProgramInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubProgramsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            MaterisRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubPrograms::route('/'),
            'create' => CreateSubProgram::route('/create'),
            'view' => ViewSubProgram::route('/{record}'),
            'edit' => EditSubProgram::route('/{record}/edit'),
        ];
    }
}
