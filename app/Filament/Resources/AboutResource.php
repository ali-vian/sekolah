<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages;
use App\Filament\Resources\AboutResource\RelationManagers;
use App\Models\About;
use Doctrine\DBAL\Query\Limit;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\Layout\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function Livewire\wrap;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationGroup = 'Profil';

    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                TextArea::make('description')
                    ->required()
                    ->placeholder('Deskripsi')
                    ->rows(10)
                    ->columnSpan(['default' => 3,
                                'lg' => 1]),
                FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios(['1:1'])
                    ->required()
                    ->columnSpan(['default' => 3,
                                'lg' => 1]),
                TextArea::make('sambutan')
                    ->required()
                    ->placeholder('Sambutan')
                    ->rows(10)
                    ->columnSpan(['default' => 3,
                                'lg' => 1]),
                Repeater::make('fasilitas')
                    ->schema([
                        FileUpload::make('icon_fasilitas')
                            ->directory('fasilitas/images')
                            ->image()
                            ->maxSize(1024) // Maksimal 1MB
                            ->label('Upload Image'),
                        TextInput::make('fasilitas')
                            ->required()
                            ->label('Fasilitas'),
                        TextArea::make('deskripsi_fasilitas')
                            ->required()
                            ->label('Deskripsi Fasilitas'),
                    ])->addActionLabel('Tambah Fasilitas')
                    ->maxItems(4)->columnSpan(3),
                FileUpload::make('gambar_sambutan')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios(['1:1'])
                    ->required()
                    ->columnSpan(['default' => 3,
                                'lg' => 1]),
                FileUpload::make('gambar_sejarah')
                ->image()
                ->imageEditor()
                ->imageEditorAspectRatios(['1:1'])
                ->required()
                ->columnSpan(['default' => 3,
                                'lg' => 1]),
                FileUpload::make('gambar_visi')
                ->image()
                ->imageEditor()
                ->imageEditorAspectRatios(['1:1'])
                ->required()
                ->columnSpan(['default' => 3,
                                'lg' => 1]),
                RichEditor::make('sejarah')
                    ->required()
                    ->placeholder('Sejarah')->columnSpan(3),
                RichEditor::make('visi')
                    ->required()
                    ->placeholder('Visi')->columnSpan(3),
                RichEditor::make('misi')
                    ->required()
                    ->placeholder('Misi')->columnSpan(3),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
        
            ->columns([
                    TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(75)
                    ->wrap(),
                    ImageColumn::make('image')->label('Image'),

                    TextColumn::make('icon_fasilitas')
                    ->label('Icon Fasilitas')
                    ->html() // Aktifkan mode HTML untuk gambar
                    ->getStateUsing(function ($record) {
                        $fasilitas = is_string($record->fasilitas) ? json_decode($record->fasilitas, true) : $record->fasilitas;
                        return collect($fasilitas)
                            ->map(fn ($item) => "<img src='/storage/{$item['icon_fasilitas']}' width='40' height='40'>")
                            ->implode(" ");
                    }),

                    TextColumn::make('nama_fasilitas')
                    ->label('Fasilitas')
                    ->getStateUsing(function ($record) {
                        $fasilitas = is_string($record->fasilitas) ? json_decode($record->fasilitas, true) : $record->fasilitas;

                        return collect($fasilitas)
                            ->map(fn ($item) => "{$item['fasilitas']}<br>")
                            ->implode("\n");
                    })
                    ->markdown(),

                    TextColumn::make('deskripsi_fasilitas')
                    ->label('Deskripsi Fasilitas')
                    ->getStateUsing(function ($record) {
                        $fasilitas = is_string($record->fasilitas) ? json_decode($record->fasilitas, true) : $record->fasilitas;

                        return collect($fasilitas)
                            ->map(fn ($item) => "{$item['deskripsi_fasilitas']}<br>")
                            ->implode("\n");
                    })
                    ->markdown(),



                    TextColumn::make('sambutan')->label('Sambutan')
                    ->limit(75)->wrap(),
                    ImageColumn::make('gambar_sambutan')->label('Gambar Sambutan'),
                    TextColumn::make('sejarah')->label('Sejarah')
                    ->limit(75)->wrap(),
                    ImageColumn::make('gambar_sejarah')->label('Gambar Sejarah'),
                    TextColumn::make('visi')->label('Visi')
                    ->limit(75)->wrap(),
                    ImageColumn::make('gambar_visi')->label('Gambar Visi'),
                    TextColumn::make('misi')->label('Misi')
                    ->limit(75)->wrap(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListAbouts::route('/'),
            'create' => Pages\CreateAbout::route('/create'),
            'edit' => Pages\EditAbout::route('/{record}/edit'),
        ];
    }
}
