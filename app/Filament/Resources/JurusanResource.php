<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JurusanResource\Pages;
use App\Filament\Resources\JurusanResource\RelationManagers;
use App\Models\Jurusan;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Tables\Table;

class JurusanResource extends Resource
{
    protected static ?string $model = Jurusan::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';
    protected static ?string $navigationGroup = 'Profil';

    protected static ?int $navigationSort = 15;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                
                TextInput::make('name')
                    ->required()
                    ->placeholder('Nama')
                    ->maxLength(255)
                    ->live(debounce: 500)
                    ->afterStateUpdated(fn (Set $set , ?string $state) => $set('slug', \Str::slug($state))),
                TextInput::make('slug')->required()->unique(ignorable: fn (?Jurusan $record) => $record)
                    ->validationMessages([
                    'unique' => 'Slug wajib unik.',]),
                RichEditor::make('description')
                    ->required()
                    ->placeholder('Deskripsi')
                    ->validationMessages([
                        'required' => 'Deskripsi wajib diisi.',]),
                FileUPload::make('icon')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios(['1:1'])
                    ->required(),
                RichEditor::make('prospek_kerja')
                    ->required()
                    ->placeholder('Prospek Kerja'),
                RichEditor::make('kompetensi')
                    ->required()
                    ->placeholder('Kompetensi'),
                Repeater::make('gambar')
                    ->schema([
                        FileUpload::make('foto')
                            ->directory('jurusan/images')
                            ->image()
                            ->maxSize(1024) // Maksimal 1MB
                            ->label('Upload Image')
                    ])->addActionLabel('Tambah Gambar'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                ImageColumn::make('icon'),
                TextColumn::make('name'),
                TextColumn::make('description')->limit(50),
                TextColumn::make('prospek_kerja')->limit(50),
                TextColumn::make('kompetensi')->limit(50),
                TextColumn::make('gambar')
                    ->label('Gambar')
                    ->html() // Aktifkan mode HTML untuk gambar
                    ->getStateUsing(function ($record) {
                        $gambars = is_string($record->gambar) ? json_decode($record->gambar, true) : $record->gambar;
                        return collect($gambars)
                            ->map(fn ($item) => "<img src='/storage/{$item['foto']}' width='40' height='40'>")
                            ->implode(" ");
                    }),
                TextColumn::make('slug')
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
            'index' => Pages\ListJurusans::route('/'),
            'create' => Pages\CreateJurusan::route('/create'),
            'edit' => Pages\EditJurusan::route('/{record}/edit'),
        ];
    }
}
