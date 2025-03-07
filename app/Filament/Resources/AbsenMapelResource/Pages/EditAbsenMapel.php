<?php

namespace App\Filament\Resources\AbsenMapelResource\Pages;

use App\Filament\Resources\AbsenMapelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAbsenMapel extends EditRecord
{
    protected static string $resource = AbsenMapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
