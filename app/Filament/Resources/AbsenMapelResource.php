<?php

// namespace App\Filament\Resources;

// use App\Filament\Resources\AbsenMapelResource\Pages;
// use App\Models\AbsenMapel;
// use Filament\Resources\Resource;
// use Filament\Tables;
// use Filament\Tables\Columns\TextColumn;
// use Filament\Forms\Components\TextInput;
// use Filament\Forms\Form;
// use Filament\Tables\Table;
// use App\Models\Student;
// use Guava\FilamentIconSelectColumn\Tables\Columns\IconSelectColumn;
// use Carbon\Carbon;
// use Filament\Forms\Components\Select;
// use Filament\Forms\Components\DatePicker;
// use Filament\Tables\Actions\Action;
// use Filament\Tables\Actions\BulkAction;
// use Filament\Tables\Filters\Filter;
// use Filament\Forms\Components\Card;
// use Illuminate\Database\Eloquent\Builder;
// use App\Models\Jadwal; // Make sure to import the Jadwal model
// use Illuminate\Support\Facades\Session;

// class AbsenMapelResource extends Resource
// {
//     protected static ?string $model = AbsenMapel::class;

//     protected static ?string $navigationIcon = 'heroicon-o-clipboard';

//     // Get jadwal_id from session or use default
//     protected static function getSelectedJadwalId(): int
//     {
//         return Session::get('selected_jadwal_id', 12);
//     }

//     // Set jadwal_id in session
//     protected static function setSelectedJadwalId(int $jadwal_id): void
//     {
//         Session::put('selected_jadwal_id', $jadwal_id);
//     }

//     public static function form(Form $form): Form
//     {
//         return $form
//             ->schema([
//                 //
//             ]);
//     }

//     public static function getColumn($jadwal_id = null)
//     {
//         // Use the provided jadwal_id or get from session
//         $jadwal_id = $jadwal_id ?? self::getSelectedJadwalId();
        
//         $dates = AbsenMapel::distinct()->where('jadwal_id', $jadwal_id)->pluck('waktu_absen')->sort()->map(function ($date) {
//             return Carbon::parse($date);
//         });

//         $columns = [
//             TextColumn::make('name')
//                 ->label('Nama')
//                 ->sortable()
//                 ->searchable(),
//         ];

//         foreach ($dates as $date) {
//             $dateFormatted = $date->format('Y-m-d');
//             $columnName = 'attendance_' . $dateFormatted;
            
//             $columns[] = IconSelectColumn::make($columnName)
//                 ->label($date->format('d/m'))
//                 ->options([
//                     'Hadir' => 'Hadir',
//                     'Sakit' => 'Sakit',
//                     'Izin' => 'Izin',
//                     'Absen' => 'Absen',
//                     '-' => '-',
//                 ])
//                 ->icons([
//                     'Hadir' => 'heroicon-s-check-circle',
//                     'Sakit' => 'heroicon-s-plus-circle',
//                     'Izin' => 'heroicon-s-information-circle',
//                     'Absen' => 'heroicon-s-x-circle',
//                     '-' => 'heroicon-s-minus-circle',
//                 ])
//                 ->getStateUsing(function ($record) use ($dateFormatted, $jadwal_id) {
//                     $status = self::getStatus($record, $dateFormatted, $jadwal_id);
//                     return $status !== '-' ? $status : '-';
//                 })
//                 ->updateStateUsing(function ($state, $record, $column) use ($dateFormatted, $jadwal_id) {
//                     // Find existing attendance record
//                     $absensi = AbsenMapel::where('student_id', $record->id)
//                         ->whereDate('waktu_absen', $dateFormatted)
//                         ->where('jadwal_id', $jadwal_id)
//                         ->first();
                    
//                     if ($absensi) {
//                         // Update existing record
//                         $absensi->update([
//                             'status' => $state,
//                         ]);
//                     } else if ($state !== '-') {
//                         // Create new record if status is not '-'
//                         AbsenMapel::create([
//                             'student_id' => $record->id,
//                             'waktu_absen' => $dateFormatted . ' 00:00:00',
//                             'jadwal_id' => $jadwal_id,
//                             'status' => $state,
//                         ]);
//                     }
//                 });
//         }

//         return $columns;
//     }

//     public static function table(Table $table): Table
//     {
//         $selectedJadwalId = self::getSelectedJadwalId();
        
//         return $table
//             ->query(Student::query())
//             ->columns(self::getColumn($selectedJadwalId))
//             ->modifyQueryUsing(function (Builder $query) use ($selectedJadwalId) {
//                 return $query->with(['absenmapel' => function($query) use ($selectedJadwalId) {
//                     $query->where('jadwal_id', $selectedJadwalId);
//                 }]);
//             })
//             ->persistFiltersInSession()
//             ->recordUrl(null)
//             ->filters([
//                 Filter::make('jadwal_filter')
//                     ->form([
//                         Select::make('jadwal_id')
//                             ->label('Pilih Jadwal')
//                             ->options(function() {
//                                 // Replace with your actual Jadwal model relation
//                                 return Jadwal::pluck('hari', 'id')->toArray();
//                                 // Alternative if you don't have a Jadwal model:
//                                 // return AbsenMapel::distinct()->pluck('jadwal_id', 'jadwal_id')->toArray();
//                             })
//                             ->default(self::getSelectedJadwalId())
//                             ->required(),
//                     ])
//                     ->query(function (Builder $query, array $data): Builder {
//                         if (isset($data['jadwal_id'])) {
//                             self::setSelectedJadwalId((int) $data['jadwal_id']);
//                         }
                        
//                         return $query;
//                     })
//                     // This line is critical - it tells Filament to reset the table when this filter changes
//                     ->indicateUsing(function (array $data): ?string {
//                         if (isset($data['jadwal_id'])) {
//                             $jadwalName = Jadwal::find($data['jadwal_id'])->nama_jadwal ?? $data['jadwal_id'];
//                             return 'Jadwal: ' . $jadwalName;
//                         }
                        
//                         return null;
//                     }),
                    
//                 Filter::make('date')
//                     ->form([
//                         DatePicker::make('created_from')
//                             ->label('Dari Tanggal'),
//                         DatePicker::make('created_until')
//                             ->label('Sampai Tanggal'),
//                     ])
//                     ->query(function (Builder $query, array $data): Builder {
//                         $selectedJadwalId = self::getSelectedJadwalId();
                        
//                         return $query
//                             ->when(
//                                 $data['created_from'],
//                                 fn (Builder $query, $date): Builder => $query->whereHas(
//                                     'absenmapel',
//                                     fn (Builder $query) => $query->whereDate('waktu_absen', '>=', $date)
//                                         ->where('jadwal_id', $selectedJadwalId)
//                                 )
//                             )
//                             ->when(
//                                 $data['created_until'],
//                                 fn (Builder $query, $date): Builder => $query->whereHas(
//                                     'absenmapel',
//                                     fn (Builder $query) => $query->whereDate('waktu_absen', '<=', $date)
//                                         ->where('jadwal_id', $selectedJadwalId)
//                                 )
//                             );
//                     })
//             ])
//             ->filtersFormColumns(2)
//             ->actions([
//                 // Individual student actions if needed
//             ])
//             ->bulkActions([
//                 // Bulk actions if needed
//             ]);
//     }

//     public static function getStatus($record, $date, $jadwal_id = null)
//     {
//         $jadwal_id = $jadwal_id ?? self::getSelectedJadwalId();
        
//         $absensi = $record->absenmapel->first(function ($absen) use ($date, $jadwal_id) {
//             return Carbon::parse($absen->waktu_absen)->toDateString() === $date && 
//                    $absen->jadwal_id == $jadwal_id;
//         });
    
//         return $absensi ? $absensi->status : '-';
//     }

//     public static function getRelations(): array
//     {
//         return [];
//     }

//     public static function getPages(): array
//     {
//         return [
//             'index' => Pages\ListAbsenMapels::route('/'),
//             'create' => Pages\CreateAbsenMapel::route('/create'),
//             'edit' => Pages\EditAbsenMapel::route('/{record}/edit'),
//             'create-attendance' => Pages\CreateAttendance::route('/create-attendance'),
//         ];
//     }
// }


namespace App\Filament\Resources;

use App\Filament\Resources\AbsenMapelResource\Pages;
use App\Models\AbsenMapel;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Student;
use Guava\FilamentIconSelectColumn\Tables\Columns\IconSelectColumn;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Request;

class AbsenMapelResource extends Resource
{
    protected static ?string $model = AbsenMapel::class;
    protected static ?string $navigationGroup = 'Absen';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    
    // Default jadwal ID to use when none is selected
    protected static ?int $defaultJadwalId = 12;

    protected static function getSelectedJadwalId(): int
{
    $queryParam = request()->query('jadwal_id');

    if ($queryParam) {
        return (int) $queryParam;
    }

    return self::$defaultJadwalId;
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function getColumn($jadwal_id)
    {
        $dates = AbsenMapel::distinct()->where('jadwal_id', $jadwal_id)->pluck('waktu_absen')->sort()->map(function ($date) {
            return Carbon::parse($date);
        });

        $columns = [
            TextColumn::make('name')
                ->label('Nama')
                ->sortable()
                ->searchable(),
        ];

        foreach ($dates as $date) {
            $dateFormatted = $date->format('Y-m-d');
            $columnName = 'attendance_' . $dateFormatted;
            
            $columns[] = IconSelectColumn::make($columnName)
                ->label($date->format('d/m'))
                ->options([
                    'Hadir' => 'Hadir',
                    'Sakit' => 'Sakit',
                    'Izin' => 'Izin',
                    'Absen' => 'Absen',
                    '-' => '-',
                ])
                ->icons([
                    'Hadir' => 'heroicon-s-check-circle',
                    'Sakit' => 'heroicon-s-plus-circle',
                    'Izin' => 'heroicon-s-information-circle',
                    'Absen' => 'heroicon-s-x-circle',
                    '-' => 'heroicon-s-minus-circle',
                ])
                ->getStateUsing(function ($record) use ($dateFormatted, $jadwal_id) {
                    $status = self::getStatus($record, $dateFormatted, $jadwal_id);
                    return $status !== '-' ? $status : '-';
                })
                ->updateStateUsing(function ($state, $record, $column) use ($dateFormatted, $jadwal_id) {
                    // Find existing attendance record
                    $absensi = AbsenMapel::where('student_id', $record->id)
                        ->whereDate('waktu_absen', $dateFormatted)
                        ->where('jadwal_id', $jadwal_id)
                        ->first();
                    
                    if ($absensi) {
                        // Update existing record
                        $absensi->update([
                            'status' => $state,
                        ]);
                    } else if ($state !== '-') {
                        // Create new record if status is not '-'
                        AbsenMapel::create([
                            'student_id' => $record->id,
                            'waktu_absen' => $dateFormatted . ' 00:00:00',
                            'jadwal_id' => $jadwal_id,
                            'status' => $state,
                        ]);
                    }
                });
        }

        return $columns;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                // Fresh query each time
                return Student::query();
            })
            ->columns(self::getColumn(self::getSelectedJadwalId()))

            // ->columns(function () {
            //     // Get the current jadwal_id and generate columns dynamically
            //     $jadwalId = self::getSelectedJadwalId();
            //     return self::getColumn($jadwalId);
            // })
            ->modifyQueryUsing(function (Builder $query) {
                // Get the current jadwal_id
                $jadwalId = self::getSelectedJadwalId();
                
                // Load the related attendance data for the selected jadwal
                return $query->with(['absenmapel' => function($query) use ($jadwalId) {
                    $query->where('jadwal_id', $jadwalId);
                }]);
            })
            ->persistFiltersInSession()
            ->recordUrl(null)
            // ->filters([
            //     Filter::make('date')
            //         ->form([
            //             DatePicker::make('created_from')
            //                 ->label('Dari Tanggal'),
            //             DatePicker::make('created_until')
            //                 ->label('Sampai Tanggal'),
            //         ])
            //         ->query(function (Builder $query, array $data): Builder {
            //             $selectedJadwalId = self::getSelectedJadwalId();
                        
            //             return $query
            //                 ->when(
            //                     $data['created_from'] ?? null,
            //                     fn (Builder $query, $date): Builder => $query->whereHas(
            //                         'absenmapel',
            //                         fn (Builder $query) => $query->whereDate('waktu_absen', '>=', $date)
            //                             ->where('jadwal_id', $selectedJadwalId)
            //                     )
            //                 )
            //                 ->when(
            //                     $data['created_until'] ?? null,
            //                     fn (Builder $query, $date): Builder => $query->whereHas(
            //                         'absenmapel',
            //                         fn (Builder $query) => $query->whereDate('waktu_absen', '<=', $date)
            //                             ->where('jadwal_id', $selectedJadwalId)
            //                     )
            //                 );
            //         })
            // ])
            ->headerActions([
                Action::make('Pilih Jadwal')
                    ->form([
                        Select::make('jadwal_id')
                            ->label('Pilih Jadwal')
                            ->options(Jadwal::pluck('hari', 'id'))
                            ->required()
                            ->default(self::getSelectedJadwalId()),
                    ])
                    ->action(function (array $data, $livewire) {
                        return redirect(AbsenMapelResource::getUrl('index', [
                            'jadwal_id' => $data['jadwal_id']
                        ]));

                    }),
            ])
            ->actions([
                // Individual student actions if needed
            ])
            ->bulkActions([
                // Bulk actions if needed
            ]);
    }

    public static function getStatus($record, $date, $jadwal_id)
    {
        $absensi = $record->absenmapel->first(function ($absen) use ($date, $jadwal_id) {
            return Carbon::parse($absen->waktu_absen)->toDateString() === $date && 
                   $absen->jadwal_id == $jadwal_id;
        });
    
        return $absensi ? $absensi->status : '-';
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\CustomTableView::route('/'),
            'create' => Pages\CreateAbsenMapel::route('/create'),
            'edit' => Pages\EditAbsenMapel::route('/{record}/edit'),
            'create-attendance' => Pages\CreateAttendance::route('/create-attendance'),
        ];
    }
}