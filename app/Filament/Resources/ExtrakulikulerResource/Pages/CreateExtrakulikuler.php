<?php

namespace App\Filament\Resources\ExtrakulikulerResource\Pages;

use App\Filament\Resources\ExtrakulikulerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExtrakulikuler extends CreateRecord
{
    protected static string $resource = ExtrakulikulerResource::class;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl("index");
    }
}
