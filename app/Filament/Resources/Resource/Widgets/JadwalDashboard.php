<?php

namespace App\Filament\Resources\Resource\Widgets;

use Filament\Widgets\Widget;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Waktu;

class JadwalDashboard extends Widget
{
    protected static string $view = 'filament.resources.resource.widgets.jadwal-dashboard';

    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    public function mount(): void
    {
        $this->kelas = Kelas::pluck('nama_kelas', 'id')->toArray();
        $this->hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $this->data = Jadwal::with(['kelas', 'mapel', 'waktu'])
            ->get()
            ->groupBy('hari');
    }
}
