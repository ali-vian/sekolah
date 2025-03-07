<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Filament\Resources\AdminResource\RelationManagers;
use App\Models\Admin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\User;
use Dom\Text;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdminResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Guru';

    protected static ?string $navigationGroup = 'Menejemen';

    protected static ?int $navigationSort = 02;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name')
                    ->required()
                    ->placeholder('Name'),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->placeholder('********'),
                TextInput::make('email')
                    ->required()
                    ->placeholder('Email'),
                TextInput::make('nip')
                    ->required()
                    ->placeholder('NIP'),
                Select::make('jenis_kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->placeholder('Jenis Kelamin'),
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
                    $query->where('name', 'Guru Piket')->orWhere('name', 'Guru');
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
                    ->sortable(),
                TextColumn::make('nip')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jenis_kelamin')
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
