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
// use DateTime;
// use DateTimeZone;
// use Carbon\Carbon;
// use Filament\Forms\Components\DatePicker;
// use Filament\Forms\Components\Radio;
// use Filament\Forms\Components\Section;
// use Filament\Tables\Actions\Action;
// use Filament\Tables\Actions\BulkAction;
// use Filament\Tables\Filters\Filter;
// use Filament\Forms\Components\Card;
// use Illuminate\Database\Eloquent\Builder;
// use Filament\Tables\Columns\SelectColumn;
// use Filament\Forms\Components\Grid;
// use Filament\Forms\Components\Hidden;
// use Illuminate\Database\Eloquent\Collection;

// class AbsenMapelResource extends Resource
// {
//     protected static ?string $model = AbsenMapel::class;

//     protected static ?string $navigationIcon = 'heroicon-o-clipboard';

//     public static function form(Form $form): Form
//     {
//         return $form
//             ->schema([
//                 //
//             ]);
//     }

//     public static function getColumn(){
//         $dates = AbsenMapel::distinct()->pluck('waktu_absen')->sort()->map(function ($date) {
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
            
//             $columns[] = SelectColumn::make($columnName)
//                 ->label($date->format('d/m/Y'))
//                 ->options([
//                     'Hadir' => 'Hadir',
//                     'Sakit' => 'Sakit',
//                     'Ijin' => 'Ijin',
//                     'Absen' => 'Absen',
//                     '-' => '-',
//                 ])
//                 ->selectablePlaceholder(false)
//                 ->getStateUsing(function ($record) use ($dateFormatted) {
//                     $status = self::getStatus($record, $dateFormatted);
//                     return $status !== '-' ? $status : '-';
//                 })
//                 ->updateStateUsing(function ($state, $record, $column) use ($dateFormatted) {
//                     // Find existing attendance record
//                     $absensi = AbsenMapel::where('student_id', $record->id)
//                         ->whereDate('waktu_absen', $dateFormatted)
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
//                             'jadwal_id' => 1,
//                             'status' => $state,
//                         ]);
//                     }
//                 });
//         }

//         return $columns;
//     }

//     public static function table(Table $table): Table
//     {
//         return $table
//             ->query(
//                 Student::query()->with(['AbsenMapel'])
//             )
//             ->headerActions([
//                 Action::make('create_attendance')
//                     ->label('Tambah Absensi Baru')
//                     ->icon('heroicon-o-plus')
//                     ->form([
//                         DatePicker::make('tanggal_absen')
//                             ->label('Tanggal Absensi')
//                             ->required()
//                             ->default(now()),
//                         Section::make('Daftar Siswa')
//                             ->schema([
//                                 Grid::make(['default' => 1])
//                                     ->schema(function () {
//                                         $students = Student::all();
//                                         $schema = [];
                                        
//                                         foreach ($students as $student) {
//                                             $schema[] = Radio::make('student_' . $student->id)
//                                                 ->label($student->name)
//                                                 ->options([
//                                                     'Hadir' => 'Hadir',
//                                                     'Ijin' => 'Ijin',
//                                                     'Sakit' => 'Sakit',
//                                                     'Absen' => 'Absen',
//                                                 ])
//                                                 ->default('Hadir')
//                                                 ->inline()
//                                                 ->inlineLabel(true);
//                                         }
                                        
//                                         return $schema;
//                                     })
//                             ])
//                     ])
//                     ->action(function (array $data) {
//                         $tanggalAbsen = $data['tanggal_absen'] . ' 00:00:00';
                        
//                         // Process each student's attendance
//                         foreach ($data as $key => $value) {
//                             if (strpos($key, 'student_') === 0) {
//                                 $studentId = substr($key, 8); // Extract student ID from the field name
                                
//                                 // Check if record already exists
//                                 $existingRecord = AbsenMapel::where('student_id', $studentId)
//                                     ->whereDate('waktu_absen', $data['tanggal_absen'])
//                                     ->first();
                                
//                                 if ($existingRecord) {
//                                     // Update existing record
//                                     $existingRecord->update([
//                                         'status' => $value,
//                                     ]);
//                                 } else {
//                                     // Create new record
//                                     AbsenMapel::create([
//                                         'student_id' => $studentId,
//                                         'waktu_absen' => $tanggalAbsen,
//                                         'jadwal_id' => 1,
//                                         'status' => $value,
//                                     ]);
//                                 }
//                             }
//                         }
//                     })
//             ])
            
//             ->columns(
//                 self::getColumn()
//             )
//             ->modifyQueryUsing(fn ($query) => $query->with('absenmapel'))
//             ->recordUrl(null)
//             ->filters([
//                 // Tambahkan filter jika perlu
//             ])
//             ->actions([
//                 // Tables\Actions\EditAction::make(),
//             ])
//             ->bulkActions([
//                 // Tables\Actions\DeleteBulkAction::make(),
//             ]);
//     }

//     public static function getStatus($record, $date)
//     {
//         $absensi = $record->absenmapel->first(function ($absen) use ($date) {
//             return Carbon::parse($absen->waktu_absen)->toDateString() === $date;
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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\SelectColumn;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\HtmlString;

class AbsenMapelResource extends Resource
{
    protected static ?string $model = AbsenMapel::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function getColumn(){
        $dates = AbsenMapel::distinct()->pluck('waktu_absen')->sort()->map(function ($date) {
            return Carbon::parse($date);
        });

        $columns = [
            TextColumn::make('name')
                ->label('Nama')
                ->sortable()
                ->searchable(),
                IconSelectColumn::make('state')
                ->options([
                    'opt1' => 'Option 1',
                    'opt2' => 'Option 2',
                ])
                ->icons([
                    'opt1' => 'heroicon-o-check',
                    'opt2' => 'heroicon-o-x-mark',
                ]),
        ];

        foreach ($dates as $date) {
            $dateFormatted = $date->format('Y-m-d');
            $columnName = 'attendance_' . $dateFormatted;
            
            $columns[] = IconSelectColumn::make($columnName)
                ->label($date->format('d/m/Y'))
                ->options([
                    'Hadir' => 'Hadir',
                    'Sakit' => 'Sakit',
                    'Ijin' => 'Ijin',
                    'Absen' => 'Absen',
                    '-' => '-',
                ])
                ->icons([
                    'Hadir' => 'heroicon-o-check',
                    'Sakit' => 'heroicon-o-x-mark',
                    'Ijin' => 'heroicon-o-home',
                    'Absen' => 'heroicon-o-user',
                    '-' => 'heroicon-o-minus',
                ])
                // ->selectablePlaceholder(false)
                ->getStateUsing(function ($record) use ($dateFormatted) {
                    $status = self::getStatus($record, $dateFormatted);
                    return $status !== '-' ? $status : '-';
                })
                ->updateStateUsing(function ($state, $record, $column) use ($dateFormatted) {
                    // Find existing attendance record
                    $absensi = AbsenMapel::where('student_id', $record->id)
                        ->whereDate('waktu_absen', $dateFormatted)
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
                            'jadwal_id' => 1,
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
            ->query(
                Student::query()->with(['AbsenMapel'])
            )
            ->headerActions([
            //     // Add new attendance date
            //     Action::make('create_attendance')
            //         ->label('Absensi Baru')
            //         ->icon('heroicon-o-plus')
            //         ->form([
            //             DatePicker::make('tanggal_absen')
            //                 ->label('Tanggal Absensi')
            //                 ->required()
            //                 ->default(now()),
            //             Section::make('Daftar Siswa')
            //                 ->schema([
            //                     Grid::make()
            //                         ->schema(function () {
            //                             $students = Student::all();
            //                             $schema = [];
                                        
            //                             foreach ($students as $student) {
            //                                 $schema[] = Radio::make('student_' . $student->id)
            //                                     ->label($student->name)
            //                                     ->options([
            //                                         'Hadir' => 'Hadir',
            //                                         'Ijin' => 'Ijin',
            //                                         'Sakit' => 'Sakit',
            //                                         'Absen' => 'Absen',
            //                                     ])
            //                                     ->default('Hadir')
            //                                     ->inline()
            //                                     ->inlineLabel(false);
            //                             }
                                        
            //                             return $schema;
            //                         })
            //                 ])
            //         ])
            //         ->action(function (array $data) {
            //             $tanggalAbsen = $data['tanggal_absen'] . ' 00:00:00';
                        
            //             // Process each student's attendance
            //             foreach ($data as $key => $value) {
            //                 if (strpos($key, 'student_') === 0) {
            //                     $studentId = substr($key, 8); // Extract student ID from the field name
                                
            //                     // Check if record already exists
            //                     $existingRecord = AbsenMapel::where('student_id', $studentId)
            //                         ->whereDate('waktu_absen', $data['tanggal_absen'])
            //                         ->first();
                                
            //                     if ($existingRecord) {
            //                         // Update existing record
            //                         $existingRecord->update([
            //                             'status' => $value,
            //                         ]);
            //                     } else {
            //                         // Create new record
            //                         AbsenMapel::create([
            //                             'student_id' => $studentId,
            //                             'waktu_absen' => $tanggalAbsen,
            //                             'jadwal_id' => 1,
            //                             'status' => $value,
            //                         ]);
            //                     }
            //                 }
            //             }

            //             Notification::make()
            //                 ->title('Absensi berhasil disimpan')
            //                 ->success()
            //                 ->send();
            //         }),
            // ->headerActions([
                // Add new attendance date
                Action::make('create_attendance')
                    ->label('Absensi Baru')
                    ->icon('heroicon-o-plus')
                    ->form([
                        DatePicker::make('tanggal_absen')
                            ->label('Tanggal Absensi')
                            ->required()
                            ->default(now()),
                        Section::make('Daftar Absensi Siswa')
                            ->schema([
                                // Wrapper with horizontal scroll for mobile
                                Placeholder::make('attendance_table')
                                    ->content(function () {
                                        // Get all students
                                        $students = Student::all();
                                        
                                        // Start building HTML for the table
                                        $html = '
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full border divide-y divide-gray-200">
                                                <thead>
                                                    <tr>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b">No</th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b">Nama Siswa</th>
                                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b">Hadir</th>
                                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b">Ijin</th>
                                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b">Sakit</th>
                                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b">Absen</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">';
                                        
                                        // Add a row for each student
                                        foreach ($students as $index => $student) {
                                            $rowClass = $index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                                            
                                            $html .= "
                                            <tr class=\"{$rowClass}\">
                                                <td class=\"px-4 py-3 text-center whitespace-nowrap\">" . ($index + 1) . "</td>
                                                <td class=\"px-4 py-3 whitespace-nowrap\">{$student->name}</td>
                                                <td class=\"px-4 py-3 text-center\">
                                                    <input type=\"radio\" name=\"student_{$student->id}\" value=\"Hadir\" checked class=\"text-primary-600 focus:ring-primary-500 h-4 w-4 cursor-pointer\">
                                                </td>
                                                <td class=\"px-4 py-3 text-center\">
                                                    <input type=\"radio\" name=\"student_{$student->id}\" value=\"Ijin\" class=\"text-primary-600 focus:ring-primary-500 h-4 w-4 cursor-pointer\">
                                                </td>
                                                <td class=\"px-4 py-3 text-center\">
                                                    <input type=\"radio\" name=\"student_{$student->id}\" value=\"Sakit\" class=\"text-primary-600 focus:ring-primary-500 h-4 w-4 cursor-pointer\">
                                                </td>
                                                <td class=\"px-4 py-3 text-center\">
                                                    <input type=\"radio\" name=\"student_{$student->id}\" value=\"Absen\" class=\"text-primary-600 focus:ring-primary-500 h-4 w-4 cursor-pointer\">
                                                </td>
                                            </tr>";
                                        }
                                        
                                        // Close the table
                                        $html .= '
                                                </tbody>
                                            </table>
                                        </div>';
                                        
                                        return new HtmlString($html);
                                    })
                            ])
                    ])
                    ->action(function (array $data) {
                        // Debug what data we're receiving
                        info('Form data received:', $data);
                        
                        $tanggalAbsen = $data['tanggal_absen'] . ' 00:00:00';
                        $savedCount = 0;
                        
                        // Process each student's attendance
                        foreach ($data as $key => $value) {
                            if (strpos($key, 'student_') === 0) {
                                $studentId = substr($key, 8); // Extract student ID from the field name
                                
                                try {
                                    // Check if record already exists
                                    $existingRecord = AbsenMapel::where('student_id', $studentId)
                                        ->whereDate('waktu_absen', $data['tanggal_absen'])
                                        ->first();
                                    
                                    if ($existingRecord) {
                                        // Update existing record
                                        $existingRecord->status = $value;
                                        $existingRecord->save();
                                        $savedCount++;
                                    } else {
                                        // Create new record
                                        $newRecord = new AbsenMapel();
                                        $newRecord->student_id = $studentId;
                                        $newRecord->waktu_absen = $tanggalAbsen;
                                        $newRecord->jadwal_id = 1;
                                        $newRecord->status = $value;
                                        $newRecord->save();
                                        $savedCount++;
                                    }
                                } catch (\Exception $e) {
                                    // Log any database errors
                                    info("Error saving attendance for student ID: {$studentId}", [
                                        'error' => $e->getMessage()
                                    ]);
                                }
                            }
                        }
            
                        Notification::make()
                            ->title("Absensi berhasil disimpan ({$savedCount} siswa)")
                            ->success()
                            ->send();
                    }),
                // Manage attendance dates
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
            ])
            ->columns(
                self::getColumn()
            )
            ->modifyQueryUsing(fn ($query) => $query->with('absenmapel'))
            ->recordUrl(null)
            ->filters([
                Filter::make('date')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereHas(
                                    'absenmapel',
                                    fn (Builder $query) => $query->whereDate('waktu_absen', '>=', $date)
                                )
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereHas(
                                    'absenmapel',
                                    fn (Builder $query) => $query->whereDate('waktu_absen', '<=', $date)
                                )
                            );
                    })
            ])
            ->actions([
                // Individual student actions if needed
            ])
            ->bulkActions([
                // Bulk actions if needed
            ]);
    }

    public static function getStatus($record, $date)
    {
        $absensi = $record->absenmapel->first(function ($absen) use ($date) {
            return Carbon::parse($absen->waktu_absen)->toDateString() === $date;
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
            'index' => Pages\ListAbsenMapels::route('/'),
            'create' => Pages\CreateAbsenMapel::route('/create'),
            'edit' => Pages\EditAbsenMapel::route('/{record}/edit'),
        ];
    }
}