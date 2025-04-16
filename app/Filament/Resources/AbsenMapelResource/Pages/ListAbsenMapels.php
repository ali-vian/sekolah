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
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Jadwal;

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
                }),
                Action::make('switchJadwal')
                ->label('Ganti Jadwal')
                ->form([
                    \Filament\Forms\Components\Select::make('jadwal_id')
                        ->label('Pilih Jadwal')
                        ->options(function() {
                            return Jadwal::pluck('hari', 'id')->toArray();
                        })
                        ->default($this->jadwalId)
                        ->required(),
                ])
                ->action(function (array $data): void {
                    // $this->redirect(route('filament.resources.absen-mapels.index', [
                    //     'jadwal_id' => $data['jadwal_id']
                    // ]));

                    $currentUrl = url()->current();
                    $newUrl = $currentUrl . '?' . http_build_query(['jadwal_id' => $data['jadwal_id']]);
                    
                    // Use Livewire's redirect method to avoid POST method issues
                    $this->redirect($newUrl);
                })
        ];
    }

    // Property to store the current jadwal_id
    public int $jadwalId;

    // Initialize the jadwal_id from query string or use default
    public function mount(): void
    {
        parent::mount();
        $this->jadwalId = (int) request()->query('jadwal_id', 12);
    }
    
    // Override the table method to apply the jadwal_id filter
    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();
        
        return $query->with(['absenmapel' => function($query) {
            $query->where('jadwal_id', $this->jadwalId);
        }]);
    }
    
    // Override the table columns to use the current jadwal_id
    protected function getTableColumns(): array
    {
        return AbsenMapelResource::getColumn($this->jadwalId);
    }
    
    
    // Override the filter form to use the current jadwal_id for date filtering
    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\Filter::make('date')
                ->form([
                    \Filament\Forms\Components\DatePicker::make('created_from')
                        ->label('Dari Tanggal'),
                    \Filament\Forms\Components\DatePicker::make('created_until')
                        ->label('Sampai Tanggal'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    $jadwalId = $this->jadwalId;
                    
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereHas(
                                'absenmapel',
                                fn (Builder $query) => $query->whereDate('waktu_absen', '>=', $date)
                                    ->where('jadwal_id', $jadwalId)
                            )
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereHas(
                                'absenmapel',
                                fn (Builder $query) => $query->whereDate('waktu_absen', '<=', $date)
                                    ->where('jadwal_id', $jadwalId)
                            )
                        );
                })
        ];
    }
}


// namespace App\Filament\Resources\AbsenMapelResource\Pages;

// use App\Filament\Resources\AbsenMapelResource;
// use Filament\Resources\Pages\ListRecords;
// use Filament\Actions\Action;
// use Filament\Tables;
// use Illuminate\Database\Eloquent\Builder;
// use App\Models\Jadwal;
// use Filament\Forms\Components\Select;
// use Filament\Forms\Components\DatePicker;
// use Livewire\Attributes\Url;

// class ListAbsenMapels extends ListRecords
// {
//     protected static string $resource = AbsenMapelResource::class;

//     // Use Livewire's URL attribute to persist state in the URL
//     #[Url]
//     public $jadwalId = 12; // Default value

//     // Override the table method to apply the jadwal_id filter
//     protected function getTableQuery(): Builder
//     {
//         $query = parent::getTableQuery();
        
//         return $query->with(['absenmapel' => function($query) {
//             $query->where('jadwal_id', $this->jadwalId);
//         }]);
//     }
    
//     // Override the table columns to use the current jadwal_id
//     protected function getTableColumns(): array
//     {
//         return AbsenMapelResource::getColumn($this->jadwalId);
//     }
    
//     // Add a Livewire action to change the jadwal
//     public function changeJadwal($newJadwalId)
//     {
//         $this->jadwalId = (int) $newJadwalId;
        
//         // This will refresh the page with the new jadwal_id in the URL
//         $this->resetTable();
//     }
    
//     // Override the header actions to use our Livewire method
//     protected function getHeaderActions(): array
//     {
//         return [
//             Action::make('switchJadwal')
//                 ->label('Ganti Jadwal')
//                 ->form([
//                     Select::make('jadwal_id')
//                         ->label('Pilih Jadwal')
//                         ->options(function() {
//                             return Jadwal::pluck('hari', 'id')->toArray();
//                         })
//                         ->default($this->jadwalId)
//                         ->required(),
//                 ])
//                 ->action(function (array $data): void {
//                     $this->changeJadwal($data['jadwal_id']);
//                 })
//         ];
//     }
    
//     // Override the filter form to use the current jadwal_id for date filtering
//     protected function getTableFilters(): array
//     {
//         return [
//             Tables\Filters\Filter::make('date')
//                 ->form([
//                     DatePicker::make('created_from')
//                         ->label('Dari Tanggal'),
//                     DatePicker::make('created_until')
//                         ->label('Sampai Tanggal'),
//                 ])
//                 ->query(function (Builder $query, array $data): Builder {
//                     return $query
//                         ->when(
//                             $data['created_from'],
//                             fn (Builder $query, $date): Builder => $query->whereHas(
//                                 'absenmapel',
//                                 fn (Builder $query) => $query->whereDate('waktu_absen', '>=', $date)
//                                     ->where('jadwal_id', $this->jadwalId)
//                             )
//                         )
//                         ->when(
//                             $data['created_until'],
//                             fn (Builder $query, $date): Builder => $query->whereHas(
//                                 'absenmapel',
//                                 fn (Builder $query) => $query->whereDate('waktu_absen', '<=', $date)
//                                     ->where('jadwal_id', $this->jadwalId)
//                             )
//                         );
//                 })
//         ];
//     }
// }