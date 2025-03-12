<?php

namespace App\Filament\Resources\AbsenHarianResource\Pages;

use App\Filament\Resources\AbsenHarianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAbsenHarian extends EditRecord
{
    protected static string $resource = AbsenHarianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
