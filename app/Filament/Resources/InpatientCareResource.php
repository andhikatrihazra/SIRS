<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InpatientCareResource\Pages;
use App\Filament\Resources\InpatientCareResource\RelationManagers;
use App\Models\InpatientCare;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InpatientCareResource extends Resource
{
    protected static ?string $model = InpatientCare::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';
    protected static ?string $navigationGroup = 'Admission';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('patient_medical_record_number')
                    ->relationship('patient', 'name')
                    ->required(),
                Forms\Components\Select::make('room_code')
                    ->relationship('room', 'name')
                    ->required(),
                Forms\Components\DatePicker::make('admission_date')
                    ->required(),
                Forms\Components\DatePicker::make('discharge_date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('room.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('admission_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discharge_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListInpatientCares::route('/'),
            'create' => Pages\CreateInpatientCare::route('/create'),
            'edit' => Pages\EditInpatientCare::route('/{record}/edit'),
        ];
    }
}
