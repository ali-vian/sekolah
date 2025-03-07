<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MapelResource\Pages;
use App\Filament\Resources\MapelResource\RelationManagers;
use App\Models\Mapel;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class MapelResource extends Resource
{
    protected static ?string $model = Mapel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('nama_mapel')
                    ->required()
                    ->placeholder('Nama Mapel'),

                TextInput::make('kode_mapel')
                    ->required()
                    ->placeholder('Kode Mapel'),
                TextInput::make('durasi')
                    ->required()
                    ->placeholder('Durasi'),
                TextInput::make('jurusan')
                    ->required()
                    ->placeholder('Jurusan'),
                Select::make('jenjang')
                    ->options([
                        'X' => 'X',
                        'XI' => 'XI',
                        'XII' => 'XII',
                    ])
                    ->placeholder('Jenjang Kelas'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('kode_mapel')
                    ->searchable()
                    ->label('Kode Mapel'),
                TextColumn::make('nama_mapel')
                    ->searchable()
                    ->label('Nama Mapel'),
                TextColumn::make('jurusan')
                    ->label('Jurusan')
                    ->searchable(),
                TextColumn::make('jenjang')
                    ->label('Jenjang Kelas')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListMapels::route('/'),
            'create' => Pages\CreateMapel::route('/create'),
            'edit' => Pages\EditMapel::route('/{record}/edit'),
        ];
    }
}
