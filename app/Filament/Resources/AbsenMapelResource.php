<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsenMapelResource\Pages;
use App\Filament\Resources\AbsenMapelResource\RelationManagers;
use App\Models\AbsenMapel;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;


class AbsenMapelResource extends Resource
{
    protected static ?string $model = AbsenMapel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('jadwal_id'),
                TextInput::make('student_id'),
                TextInput::make('status'),
                TextInput::make('keterangan'),
                TextInput::make('waktu_absen'),
            ]);
    }

    public static function table(Table $table): Table
    {
        // return $table
        //     ->columns([
        //         //
        //         TextColumn::make('jadwal_id'),
        //         TextColumn::make('student_id'),
        //         TextColumn::make('status'),
        //         TextColumn::make('keterangan'),
        //         TextColumn::make('waktu_absen'),
        //     ])
        $dates = AbsenMapel::select('created_at')->distinct()->pluck('created_at')->toArray();

            return $table
                ->columns(
                    array_merge(
                        [
                            // Kolom Nama
                            TextColumn::make('student.name')
                                ->label('Nama')
                                ->sortable()
                                ->searchable(),
                        ],
                        // Buat kolom berdasarkan tanggal yang ada di database
                        array_map(function ($date) {
                            return TextColumn::make('date_' . $date)
                                ->label(Carbon::parse($date)->format('d M'))
                                ->getStateUsing(fn ($record) => AbsenMapel::where('student_id', $record->nama)->where('created_at', $date)->value('status') ?? '-')
                                ->badge()
                                ->color(fn ($state) => $state === 'Hadir' ? 'success' : ($state === 'Sakit' ? 'danger' : 'danger'));
                        }, $dates)
                    )
                )
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
