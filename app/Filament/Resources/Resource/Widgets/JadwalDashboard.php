<?php

namespace App\Filament\Resources\Resource\Widgets;

use Filament\Widgets\Widget;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\AbsenMapel;
use Carbon\Carbon;

class JadwalDashboard extends Widget
{
    protected static string $view = 'filament.resources.resource.widgets.jadwal-dashboard';

    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    public function mount(): void
    {
        $this->kelas = Kelas::pluck('nama_kelas', 'id')->toArray();
        $this->hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu','Minggu'];
        $this->data = Jadwal::with(['kelas', 'mapel', 'waktu'])
            ->get()
            ->groupBy('hari');
        
         // Ambil semua data absensi minggu ini
         $mingguIni = Carbon::now()->startOfWeek();
         $akhirMinggu = Carbon::now()->endOfWeek();
         
         // Ambil semua jadwal_id yang sudah melakukan absen minggu ini
         $this->absensiMingguIni = AbsenMapel::whereBetween('waktu_absen', [$mingguIni, $akhirMinggu])
             ->pluck('jadwal_id')
             ->toArray();
    }

    public function cekSudahAbsen($jadwalId): bool
    {
        return in_array($jadwalId, $this->absensiMingguIni);
    }
}
