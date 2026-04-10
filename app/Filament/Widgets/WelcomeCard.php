<?php

namespace App\Filament\Widgets;

use App\Models\Materi;
use App\Models\Peserta;
use App\Models\SubProgram;
use Filament\Widgets\Widget;

class WelcomeCard extends Widget
{
    protected string $view = 'filament.widgets.welcome-card';

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }

    protected function getViewData(): array
    {
        return [
            'totalPeserta' => Peserta::count(),
            'totalSubPrograms' => SubProgram::count(),
            'totalMateri' => Materi::count(),
        ];
    }
}
