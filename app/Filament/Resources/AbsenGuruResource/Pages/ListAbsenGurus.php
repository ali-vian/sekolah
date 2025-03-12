<?php

namespace App\Filament\Resources\AbsenGuruResource\Pages;

use App\Filament\Resources\AbsenGuruResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAbsenGurus extends ListRecords
{
    protected static string $resource = AbsenGuruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
