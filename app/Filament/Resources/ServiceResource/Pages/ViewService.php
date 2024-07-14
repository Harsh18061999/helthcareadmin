<?php
namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\ServiceResource;
use Filament\Resources\Pages\ViewRecord;

class ViewService extends ViewRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            ServiceResource\Widgets\ServiceDetails::class,
        ];
    }
}
