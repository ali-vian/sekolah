<?php

namespace App\Filament\Resources\ExtrakulikulerResource\Pages;

use App\Filament\Resources\ExtrakulikulerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExtrakulikuler extends EditRecord
{
    protected static string $resource = ExtrakulikulerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl("index");
    }
}
