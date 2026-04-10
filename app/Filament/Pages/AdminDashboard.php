<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ProgressStats;
use App\Filament\Widgets\RecentMateri;
use App\Filament\Widgets\WelcomeCard;
use Filament\Pages\Dashboard as BaseDashboard;

class AdminDashboard extends BaseDashboard
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-sparkles';

    public function getColumns(): int | array
    {
        return 2;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WelcomeCard::class,
            ProgressStats::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            RecentMateri::class,
        ];
    }
}
