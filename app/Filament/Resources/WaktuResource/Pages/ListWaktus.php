<?php

namespace App\Filament\Resources\WaktuResource\Pages;

use App\Filament\Resources\WaktuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListWaktus extends ListRecords
{
    protected static string $resource = WaktuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeader(): ?View
    {
        $data = Actions\CreateAction::make();
        return view('filament.custom.info',compact('data'));
    }
}
