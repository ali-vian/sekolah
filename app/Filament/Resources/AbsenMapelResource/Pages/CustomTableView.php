<?php

namespace App\Filament\Resources\AbsenMapelResource\Pages;

use App\Filament\Resources\AbsenMapelResource;
use App\Filament\Resources\JadwalResource;
use App\Models\AbsenMapel;
use Filament\Resources\Pages\Page;
use App\Models\Kelas;
use App\Models\Jadwal;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use GuzzleHttp\Promise\Create;

class CustomTableView extends Page
{
    protected static string $resource = AbsenMapelResource::class;

    protected static? string $title = 'Absen Mapel';

    protected static string $view = 'admin.absen';
    
    public function getViewData(): array
    {
        return [
            'kelas' => Kelas::pluck('nama_kelas', 'id')->toArray(),
            'hari' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\Action::make('Export')
            //     ->url('/')
            //     ->icon('heroicon-o-printer')
            //     ->color('success'),
            // Actions\Action::make('back')
            // ->color('warning')
            // ->label('Kembali')
            // ->url('/admin/jadwals'),
            // Actions\CreateAction::make('create')->icon('heroicon-o-plus-circle')
            // ->url('/admin/jadwals/create'),
            ];
    }
}