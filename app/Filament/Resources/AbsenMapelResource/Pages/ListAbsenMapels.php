<?php

namespace App\Filament\Resources\AbsenMapelResource\Pages;

use App\Filament\Resources\AbsenMapelResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use App\Models\AbsenMapel;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Carbon\Carbon;
use Filament\Forms\Components\Grid;

class ListAbsenMapels extends ListRecords
{
    protected static string $resource = AbsenMapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Action::make('createAttendance')
                ->label('Absensi Baru')
                ->icon('heroicon-o-plus')
                ->url(static::getResource()::getUrl('create-attendance')),
            Action::make('manage_dates')
                ->label('Kelola Tanggal')
                ->icon('heroicon-o-calendar')
                ->form([
                    Section::make('Kelola Tanggal Absensi')
                        ->description('Edit atau hapus tanggal absensi yang sudah ada')
                        ->schema(function () {
                            $dates = AbsenMapel::distinct()
                                ->pluck('waktu_absen')
                                ->sort()
                                ->map(function ($date) {
                                    return Carbon::parse($date)->format('Y-m-d');
                                })
                                ->unique();

                            $schema = [];
                            
                            foreach ($dates as $date) {
                                $formattedDate = Carbon::parse($date)->format('d/m/Y');
                                
                                $schema[] = Grid::make(3)
                                    ->schema([
                                        Placeholder::make("date_label_{$date}")
                                            ->label('Tanggal')
                                            ->content($formattedDate),
                                        
                                        DatePicker::make("edit_date_{$date}")
                                            ->label('Ubah Ke')
                                            ->default($date),
                                        
                                        Radio::make("action_{$date}")
                                            ->label('Aksi')
                                            ->options([
                                                'update' => 'Ubah',
                                                'delete' => 'Hapus',
                                                'none' => 'Biarkan'
                                            ])
                                            ->default('none')
                                            ->inline()
                                            ->inlineLabel(false)
                                    ]);
                            }
                            
                            return $schema;
                        })
                ])
                ->action(function (array $data) {
                    $updateCount = 0;
                    $deleteCount = 0;
                    
                    foreach ($data as $key => $value) {
                        if (strpos($key, 'action_') === 0) {
                            $date = substr($key, 7); // Extract date from field name
                            
                            if ($value === 'update') {
                                $newDate = $data["edit_date_{$date}"] . ' 00:00:00';
                                
                                // Get all records for the old date
                                $records = AbsenMapel::whereDate('waktu_absen', $date)->get();
                                
                                foreach ($records as $record) {
                                    $record->update([
                                        'waktu_absen' => $newDate
                                    ]);
                                }
                                
                                $updateCount += $records->count();
                            }
                            elseif ($value === 'delete') {
                                // Delete all records for this date
                                $deleteCount += AbsenMapel::whereDate('waktu_absen', $date)->delete();
                            }
                        }
                    }
                    
                    Notification::make()
                        ->title('Tanggal absensi berhasil dikelola')
                        ->body("{$updateCount} data diperbarui dan {$deleteCount} data dihapus")
                        ->success()
                        ->send();
                })
        ];
    }
}
