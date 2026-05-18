<?php

namespace App\Filament\Resources\LogUsers;

use App\Filament\Resources\LogUsers\Pages\CreateLogUser;
use App\Filament\Resources\LogUsers\Pages\EditLogUser;
use App\Filament\Resources\LogUsers\Pages\ListLogUsers;
use App\Filament\Resources\LogUsers\Schemas\LogUserForm;
use App\Filament\Resources\LogUsers\Tables\LogUsersTable;

use App\Models\LogUser;

use BackedEnum;
use UnitEnum;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

use Filament\Support\Icons\Heroicon;

use Illuminate\Database\Eloquent\Builder;

class LogUserResource extends Resource
{
    protected static ?string $model = LogUser::class;

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedUserPlus;

    protected static string|BackedEnum|null $activeNavigationIcon =
        Heroicon::OutlinedArrowDownRight;

    protected static ?string $navigationLabel =
        'Validasi Peserta';

    protected static ?string $pluralLabel =
        'Validasi Peserta';

    protected static ?string $label =
        'Validasi Peserta';

    protected static ?int $navigationSort =
        2;

    protected static string|UnitEnum|null $navigationGroup =
        'Peserta & Akun';

    //badge
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where(
            'status',
            'pending'
        )->count();
    }

    //badge color
    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    //form
    public static function form(Schema $schema): Schema
    {
        return LogUserForm::configure($schema);
    }

    //table
    public static function table(Table $table): Table
    {
        return LogUsersTable::configure($table);
    }

    //query
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()

            ->where(
                'status',
                'pending'
            );
    }

    //relation
    public static function getRelations(): array
    {
        return [];
    }

    //pages
    public static function getPages(): array
    {
        return [

            'index' =>

                ListLogUsers::route('/'),

            'create' =>

                CreateLogUser::route('/create'),

            'edit' =>

                EditLogUser::route('/{record}/edit'),

        ];
    }
}
