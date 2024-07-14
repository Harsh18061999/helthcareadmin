<?php

namespace App\Filament\Resources\DoctorResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DoctorOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Doctor', $this->getPageTableQuery()->count()),
            // Stat::make('Active', $this->getPageTableQuery()->where('status','1')->count()),
            // Stat::make('In-Active',  $this->getPageTableQuery()->where('status','0')->count()),
        ];
    }
}
