<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WaktuResource\Pages;
use App\Filament\Resources\WaktuResource\RelationManagers;
use App\Models\Waktu;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WaktuResource extends Resource
{
    protected static ?string $model = Waktu::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function query(): Builder
{
    return Waktu::query()->withoutGlobalScope(SoftDeletingScope::class)->withTrashed();
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                
                TextInput::make('nama')
                    ->required()
                    ->placeholder('Nama'),
                TimePicker::make('waktu_mulai')
                    ->displayFormat('HH:mm')
                    ->label('Waktu Mulai')
                    ->prefixIcon('heroicon-m-play')
                    ->prefixIconColor('primary')
                    ->withoutSeconds(),
                TimePicker::make('waktu_selesai')
                    ->label('Waktu Selesai')
                    ->prefixIcon('heroicon-m-check-circle')
                    ->prefixIconColor('success')
                    ->withoutSeconds()
            ]);
    }

    public static function table(Table $table): Table
    {
        logger()->info('Filament Table Data:', ['data' => Waktu::all()->toArray()]);

        return $table
            ->columns([
                //
                TextColumn::make('nama')
                    ->searchable()
                    ->label('Jam ke-')
                    ,
                TextColumn::make('waktu_mulai')
                    ->searchable()
                    ->label('Waktu Mulai')
                    ->getStateUsing(function ($record) {
                        return Carbon::parse($record->waktu_mulai)->format('H:i');
                    }),
                TextColumn::make('waktu_selesai')
                    ->searchable()
                    ->label('Waktu Selesai')
                    ->getStateUsing(function ($record) {
                        return Carbon::parse($record->waktu_selesai)->format('H:i');
                    }),
                TextColumn::make('durasi')
                ->getStateUsing(function ($record) {
                    $waktuMulai = Carbon::parse($record->waktu_mulai);
                    $waktuSelesai = Carbon::parse($record->waktu_selesai);
                    return $waktuMulai->diffInMinutes($waktuSelesai).' Menit';
                })
            ])
            
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
            'index' => Pages\ListWaktus::route('/'),
            'create' => Pages\CreateWaktu::route('/create'),
            'edit' => Pages\EditWaktu::route('/{record}/edit'),
        ];
    }
}
