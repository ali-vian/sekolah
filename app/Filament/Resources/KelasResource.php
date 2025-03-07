<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelasResource\Pages;
use App\Filament\Resources\KelasResource\RelationManagers;
use App\Models\Kelas;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('nama_kelas')
                    ->required()
                    ->placeholder('Nama Kelas'),
                TextInput::make('jurusan')
                    ->required()
                    ->placeholder('Jurusan'),
                Select::make('walikelas')
                    ->relationship('guru', 'name')
                    ->required()
                    ->placeholder('Wali Kelas'),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table


            ->columns([
                //
                TextColumn::make('nama_kelas')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('guru.name')
                    ->label('Wali Kelas')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jurusan')
                    ->searchable()
                    ->sortable(),
                    TextColumn::make('jumlah_siswa')
                    ->label('Jumlah Siswa')
                    ->getStateUsing(fn ($record) => $record->siswa()->count()),
                
                
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

            return $record->siswa->count();
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
            'index' => Pages\ListKelas::route('/'),
            'create' => Pages\CreateKelas::route('/create'),
            'edit' => Pages\EditKelas::route('/{record}/edit'),
        ];
    }
}
