<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Peserta;
use App\Models\SubProgram;
use App\Models\Materi;
use App\Models\Progress;

class ProgressStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalPeserta = Peserta::count();
        $totalKelas = SubProgram::count();
        $totalMateri = Materi::count();

        $totalProgress = Progress::count();
        $totalHadir = Progress::where('status', 'hadir')->count();

        $persentase = $totalProgress > 0
            ? round(($totalHadir / $totalProgress) * 100, 1)
            : 0;

        return [
            Stat::make('Total Peserta', number_format($totalPeserta))
                ->description('Peserta aktif')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Total Kelas', number_format($totalKelas))
                ->description('Kelas berjalan')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),

            Stat::make('Total Materi', number_format($totalMateri))
                ->description('Materi tersedia')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('warning'),

            // Stat::make('Total Kehadiran', number_format($totalHadir))
            //     ->description('Progress tercatat')
            //     ->descriptionIcon('heroicon-m-clipboard-document-check')
            //     ->color('success'),

            // Stat::make('Persentase Kehadiran', $persentase . '%')
            //     ->description('Target minimal 80%')
            //     ->descriptionIcon('heroicon-m-arrow-trending-up')
            //     ->color($persentase >= 80 ? 'success' : 'danger'),
        ];
    }
}
