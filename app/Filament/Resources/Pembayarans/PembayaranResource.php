<?php

namespace App\Filament\Resources\Pembayarans;

use App\Filament\Resources\Pembayarans\Pages\CreatePembayaran;
use App\Filament\Resources\Pembayarans\Pages\EditPembayaran;
use App\Filament\Resources\Pembayarans\Pages\ListPembayarans;
use App\Filament\Resources\Pembayarans\Pages\ViewPembayaran;

use App\Filament\Resources\Pembayarans\Schemas\PembayaranForm;
use App\Filament\Resources\Pembayarans\Schemas\PembayaranInfolist;
use App\Filament\Resources\Pembayarans\Tables\PembayaransTable;

use App\Models\Transaction;

use BackedEnum;
use UnitEnum;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

use Filament\Support\Icons\Heroicon;

class PembayaranResource extends Resource
{
    protected static ?string $model =
        Transaction::class;

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedCurrencyDollar;

    protected static string|BackedEnum|null $activeNavigationIcon =
        Heroicon::OutlinedArrowDownRight;

    protected static string|UnitEnum|null $navigationGroup =
        'Operasional';

    protected static ?int $navigationSort =
        1;

    protected static ?string $navigationLabel =
        'Pembayaran';

    protected static ?string $pluralLabel =
        'Pembayaran';

    protected static ?string $label =
        'Pembayaran';

    //badge
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereIn(
            'transaction_status',
            [
                'pending',
                'challenge',
            ]
        )->count();
    }

    //badge color
    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    //form
    public static function form(Schema $schema): Schema
    {
        return PembayaranForm::configure($schema);
    }

    //infolist
    public static function infolist(Schema $schema): Schema
    {
        return PembayaranInfolist::configure($schema);
    }

    //table
    public static function table(Table $table): Table
    {
        return PembayaransTable::configure($table);
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

                ListPembayarans::route('/'),

            'create' =>

                CreatePembayaran::route('/create'),

            'view' =>

                ViewPembayaran::route('/{record}'),

            'edit' =>

                EditPembayaran::route('/{record}/edit'),

        ];
    }

    //disable create
    public static function canCreate(): bool
    {
        return false;
    }
}
