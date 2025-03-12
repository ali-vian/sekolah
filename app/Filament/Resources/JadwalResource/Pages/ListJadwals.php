<?php

namespace App\Filament\Resources\JadwalResource\Pages;

use App\Filament\Resources\JadwalResource;
use Filament\Actions;
use Filament\Actions\Modal\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\View\View;
use App\Models\Jadwal;
use App\Models\Kelas;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;


class ListJadwals extends ListRecords
{
    protected static string $resource = JadwalResource::class;

    protected static? string $title = 'Jadwal Pelajaran';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('custom_table')
            ->icon('heroicon-o-eye')
            ->color('warning')
            ->label('Lihat Jadwal')
            ->url(static::getResource()::getUrl('custom-table')),
            Actions\CreateAction::make()->icon('heroicon-o-plus-circle'),
            ];
    }
}
