<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalResource\Pages;
use App\Filament\Resources\JadwalResource\RelationManagers;
use App\Models\Jadwal;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use App\Models\Waktu;
use App\Filament\Resources\JadwalResource\Widgets\CustomTableWidget;
 
FilamentColor::register([
    'indigo' => Color::Violet,
]);

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JadwalResource extends Resource
{
    public static function getWidgets(): array
    {
        return [
            CustomTableWidget::class,
        ];
    }
    protected static ?string $model = Jadwal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                Select::make('hari')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                        'Minggu' => 'Minggu',
                    ])
                    ->required()
                    ->placeholder('Hari'),
                Select::make('waktu_id')
                    ->relationship('waktu', 'nama')
                    ->required()
                    ->placeholder('Waktu'),
                Select::make('kelas_id')
                    ->relationship('kelas', 'nama_kelas')
                    ->required()
                    ->placeholder('Kelas'),
                Select::make('mapel_id')
                    ->relationship('mapel', 'nama_mapel')
                    ->required()
                    ->placeholder('Mapel'),
                Select::make('guru_id')
                    ->relationship('guru', 'name')
                    ->required()
                    ->placeholder('Guru'),
            ]);
    }    


    public static function table(Table $table): Table
    {
        
        return $table

            ->defaultGroup('hari')
            ->defaultSort('waktu_id', 'asc')
            ->columns([
                
                TextColumn::make('hari')
                ->label('Hari')
                ->badge() // Menjadikan teks berbentuk badge
                ->color(fn ($state) => match ($state) {
                    'Senin' => 'success',
                    'Selasa' => 'info',
                    'Rabu' => 'gray',
                    'Kamis' => 'danger',
                    'Jumat' => 'warning',
                    'Sabtu' => 'primary',
                    'Minggu' => 'indigo',
                }),
                TextColumn::make('waktu.nama')
                ->searchable(),
                TextColumn::make('kelas.nama_kelas')
                ->searchable(),
                TextColumn::make('mapel.nama_mapel')
                ->searchable(),
                TextColumn::make('guru.name')
                ->searchable(),
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
            'index' => Pages\ListJadwals::route('/'),
            'create' => Pages\CreateJadwal::route('/create'),
            'edit' => Pages\EditJadwal::route('/{record}/edit'),
        ];
    }
}
