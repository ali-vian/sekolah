<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsenGuruResource\Pages;
use App\Filament\Resources\AbsenGuruResource\RelationManagers;
use App\Models\AbsenGuru;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AbsenGuruResource extends Resource
{
    protected static ?string $navigationGroup = 'Absen';
    protected static ?string $model = AbsenGuru::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListAbsenGurus::route('/'),
            'create' => Pages\CreateAbsenGuru::route('/create'),
            'edit' => Pages\EditAbsenGuru::route('/{record}/edit'),
        ];
    }
}
