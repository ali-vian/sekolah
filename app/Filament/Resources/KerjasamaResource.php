<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KerjasamaResource\Pages;
use App\Filament\Resources\KerjasamaResource\RelationManagers;
use App\Models\Kerjasama;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
class KerjasamaResource extends Resource
{
    
    protected static ?string $model = Kerjasama::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationGroup = 'Profil';

    protected static ?int $navigationSort = 14;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios(['1:1'])
                    ->required(),
                TextInput::make('nama_perusahaan')
                    ->required()
                    ->placeholder('Nama Perusahaan'),
                Toggle::make('status')->label('Status')
                    ->onIcon('heroicon-m-check-badge')
                    ->onColor('success')
                    ->offIcon('heroicon-m-x-mark')
                    ->offColor('danger')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                ImageColumn::make('image'),
                TextColumn::make('nama_perusahaan')
                ->searchable(),
                ToggleColumn::make('status')
                    ->label('Status')
                    ->onColor('success')
                    ->offColor('danger')

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
            'index' => Pages\ListKerjasamas::route('/'),
            'create' => Pages\CreateKerjasama::route('/create'),
            'edit' => Pages\EditKerjasama::route('/{record}/edit'),
        ];
    }
}
