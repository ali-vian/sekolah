<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $label = 'Murid';
    protected static ?string $navigationGroup = 'Menejemen';

    protected static ?int $navigationSort = 02;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('tahun_masuk')
                    ->required(),
                TextInput::make('nama')
                    ->required()
                    ->placeholder('Nama'),
                Select::make('jenis_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->placeholder('Jenis Kelamin'),
                TextInput::make('asal_sd'),
                TextInput::make('asal_smp'),
                TextInput::make('nik'),
                TextInput::make('nisn')
                    ->placeholder('NISN'),
                TextInput::make('urut_yayasan'),
                TextInput::make('urut_jurusan'),
                TextInput::make('kode_jurusan'),
                TextInput::make('tempat_lahir'),
                DatePicker::make('tanggal_lahir'),
                TextInput::make('ibu'),
                TextInput::make('ayah'),
                TextInput::make('alamat'),
                TextInput::make('anak_ke'),
                Select::make('kelas_id')
                    ->relationship('kelas', 'nama_kelas')
                    ->required()
                    ->placeholder('Kelas'),
                Select::make('status')
                ->options([
                    0 => 0,
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 6,
                
                ])
                
                
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('nisn')
                    ->searchable()
                    ->label('NISN'),
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('kelas.nama_kelas')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jenis_kelamin')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tahun_masuk')
                    ->searchable()
                    ->sortable()
                
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
