<?php

namespace App\Filament\Resources\Resource\Widgets;

use App\Models\Jadwal;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Widgets\TableWidget as BaseWidget;

class TodayScheduleWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getTableHeading(): string
    {
        return 'Jadwal Mengajar Hari Ini - ' . $this->getIndonesianDayName();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Query jadwal untuk guru yang login dan hari ini
                Jadwal::query()
                    ->where('guru_id', auth()->id())
                    ->where('hari', $this->getIndonesianDayName())
                    ->orderBy('waktu_id')
            )
            ->columns([
                Tables\Columns\TextColumn::make('waktu.nama')
                    ->label('Waktu'),
                
                Tables\Columns\TextColumn::make('kelas.nama_kelas')
                    ->label('Kelas'),
                
                Tables\Columns\TextColumn::make('mapel.nama_mapel')
                    ->label('Mata Pelajaran'),
                    
                // Tables\Columns\TextColumn::make('status')
                //     ->label('Status')
                //     ->getStateUsing(function ($record) {
                //         $absensi = $record->absenGuru()
                //             ->whereDate('created_at', Carbon::today())
                //             ->first();
                        
                //         return $absensi ? 'Sudah Absen' : 'Belum Absen';
                //     })
                //     ->badge()
                //     ->color(fn (string $state): string => match ($state) {
                //         'Sudah Absen' => 'success',
                //         'Belum Absen' => 'warning',
                //     }),
            ])
            ->emptyStateHeading('Tidak ada jadwal mengajar hari ini')
            ->emptyStateIcon('heroicon-o-calendar')
            ->paginated(false);
    }

    protected function getIndonesianDayName(): string
    {
        $dayNames = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        return $dayNames[Carbon::now()->format('l')];
    }

    public static function canView(): bool
    {
        // Untuk sementara, aktifkan untuk semua pengguna untuk testing
        return true;
    }
}