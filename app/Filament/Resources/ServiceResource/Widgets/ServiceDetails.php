<?php

namespace App\Filament\Resources\ServiceResource\Widgets;

use App\Models\Services;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Builder;

class ServiceDetails extends Widget
{
    public $record;

    protected static string $view = 'filament.resources.category-resource.widgets.category-details';

    protected function getViewData(): array
    {
        $category = Services::with('children')->find($this->record->id);

        return [
            'category' => $category,
            'children' => $category->children,
        ];
    }
}
