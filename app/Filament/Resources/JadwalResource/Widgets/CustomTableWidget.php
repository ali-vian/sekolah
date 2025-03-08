<?php

namespace App\Filament\Resources\JadwalResource\Widgets;
use App\Models\User; // Sesuaikan dengan model yang digunakan

use Filament\Widgets\Widget;

class CustomTableWidget extends Widget
{
    protected static string $view = 'filament.resources.jadwal-resource.widgets.custom-table-widget';
    protected function getViewData(): array
    {
        return [
            'records' => User::all(), // Sesuaikan dengan model yang digunakan
        ];
    }
}
