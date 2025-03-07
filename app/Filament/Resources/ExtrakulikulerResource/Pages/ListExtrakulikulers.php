<?php

namespace App\Filament\Resources\ExtrakulikulerResource\Pages;

use App\Filament\Resources\ExtrakulikulerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtrakulikulers extends ListRecords
{
    protected static string $resource = ExtrakulikulerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
