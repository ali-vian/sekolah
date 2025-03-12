<?php

namespace App\Filament\Resources\AbsenMapelResource\Pages;

use App\Filament\Resources\AbsenMapelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAbsenMapels extends ListRecords
{
    protected static string $resource = AbsenMapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
