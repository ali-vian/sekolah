<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $label = 'Admin';

    protected static ?string $navigationGroup = 'Menejemen';

    protected static ?int $navigationSort = 01;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name')
                    ->required()
                    ->placeholder('Name'),
                TextInput::make('email')
                    ->required()
                    ->placeholder('Email'),
                TextInput::make('password')
                    ->required()
                    ->placeholder('Password')
                    ->password()
                    ->autocomplete('new-password'),
                Forms\Components\Select::make('roles')
                ->relationship('roles', 'name')
                ->multiple()
                ->preload()
                ->searchable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->query(
            User::query()
                ->with('roles')
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'super_admin')->orWhere('name', 'Admin Profil');
                })
        )
            ->columns([
                //
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('roles.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
            ])
            ->filters([
                //
                SelectFilter::make('user')
                ->relationship('roles', 'name')

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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
