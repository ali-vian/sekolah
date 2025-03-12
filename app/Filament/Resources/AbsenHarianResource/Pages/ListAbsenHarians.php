<?php

namespace App\Filament\Resources\AbsenHarianResource\Pages;

use App\Filament\Resources\AbsenHarianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAbsenHarians extends ListRecords
{
    protected static string $resource = AbsenHarianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
