<?php

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
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
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
        $dates = AbsenMapel::distinct()->where('jadwal_id',5)->pluck('waktu_absen')->sort()->map(function ($date) {
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
                ->colors([
                    'Hadir' => 'success',
                    'Sakit' => 'primary',
                    'Izin' => 'warning',
                    'Absen' => 'danger',
                    // '-' => 'gray',
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
            // ->striped()
            ->query(
                Student::query()->with(['AbsenMapel'])
            )
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
            'create-attendance' => Pages\CreateAttendance::route('/create-attendance'),
        ];
    }
}