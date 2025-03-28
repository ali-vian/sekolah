<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Filament\Resources\AnnouncementResource\RelationManagers;
use App\Models\Announcement;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\Image;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Forms\Set;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationLabel = 'Pengumuman';

    public static ?string $label = 'Pengumuman';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Profil';

    protected static ?int $navigationSort = 17;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->placeholder('Title')
                    ->maxLength(255)
                    ->live(debounce: 500)
                    ->afterStateUpdated(fn (Set $set , ?string $state) => $set('slug', \Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->placeholder('Slug')
                    ->unique(ignorable: fn (?Announcement $record) => $record),
                TextInput::make('author')
                    ->required()
                    ->placeholder('Author'),
                TextArea::make('category')
                    ->required()
                    ->placeholder('Category')
                    ->rows(3),
                FileUpload::make('image')
                ->image()
                ->imageEditor()
                ->imageEditorAspectRatios([
                    '16:9',
                    '4:3',
                    '1:1',
                    ])->required(),
                RichEditor::make('content')
                    ->required()
                    ->placeholder('Content')
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
                TextColumn::make('author'),
                TextColumn::make('content')
                    ->searchable()
                    ->limit(100)
                    ->wrap(),
                TextColumn::make('slug')
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
