<?php

namespace App\Filament\Resources\JadwalResource\Pages;

use App\Filament\Resources\JadwalResource;
use Filament\Actions;
use Filament\Actions\Modal\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListJadwals extends ListRecords
{
    protected static string $resource = JadwalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Export')
                ->url('/')
                ->icon('heroicon-o-printer')
                ->color('success'),
            Actions\Action::make('Lihat Jadwal')
                ->url('/jadwal/lihat-jadwal')
                ->icon('heroicon-o-eye')
                ->color('warning'),
            Actions\CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
