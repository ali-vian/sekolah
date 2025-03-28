<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Filament\Forms\Set;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;


    protected static ?string $navigationLabel = 'Berita';

    protected static ?string $navigationGroup = 'Profil';

    protected static ?int $navigationSort = 16;

    public static ?string $label = 'Berita';

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('title')
                    ->required()
                    ->placeholder('Title')
                    ->maxLength(255)
                    ->live(debounce: 500)
                    ->afterStateUpdated(fn (Set $set , ?string $state) => $set('slug', \Str::slug($state))),
                TextInput::make('slug')->required()->unique(ignorable: fn (?News $record) => $record),
                TextInput::make('category')
                    ->required()
                    ->placeholder('Category'),
                RichEditor::make('content')
                    ->required()
                    ->placeholder('Content'),
                FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                ImageColumn::make('image'),
               
                TextColumn::make('title')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('category')
                    ->searchable()
                    ,
                TextColumn::make('content')
                    ->searchable()
                    ->limit(100)
                    ->wrap(),
                TextColumn::make('slug')->limit(20),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
