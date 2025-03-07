<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumniResource\Pages;
use App\Filament\Resources\AlumniResource\RelationManagers;
use App\Models\Alumni;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Ramsey\Uuid\Type\NumberInterface;

class AlumniResource extends Resource
{
    protected static ?string $model = Alumni::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Profil';

    protected static ?int $navigationSort = 13;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios(['1:1'])
                    ->required()
                    ->columnSpan(3),
                TextInput::make('name')
                    ->required()
                    ->placeholder('Nama')
                    ->columnSpan(['default' => 3,
                                'lg' => 1]),
                TextInput::make('jurusan')
                    ->required()
                    ->placeholder('Jurusan')
                    ->columnSpan(['default' => 3,
                                'lg' => 1]),
                TextInput::make('angkatan')
                    ->type('number')
                    ->required()
                    ->placeholder('Angkatan')
                    ->columnSpan(['default' => 3,
                                'lg' => 1]),
                TextInput::make('pekerjaan')
                    ->required()
                    ->placeholder('Pekerjaan')
                    ->columnSpan(['default' => 3,
                                'lg' => 1]),
                TextInput::make('tempatKerja') 
                    ->required()
                    ->placeholder('Tempat Kerja')
                    ->columnSpan(['default' => 3,
                                'lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                ImageColumn::make('image')
                    ->label('Foto')
                    ->size(100)
                    ->circular(),
                TextColumn::make('name')->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jurusan')->label('Jurusan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('angkatan')->label('Angkatan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pekerjaan')->label('Pekerjaan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tempatKerja')->label('Tempat Kerja')
                    ->searchable()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAlumnis::route('/'),
            'create' => Pages\CreateAlumni::route('/create'),
            'edit' => Pages\EditAlumni::route('/{record}/edit'),
        ];
    }
}
