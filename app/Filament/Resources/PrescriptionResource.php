<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Medicine;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Prescription;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PrescriptionResource\Pages;
use App\Filament\Resources\PrescriptionResource\RelationManagers;

class PrescriptionResource extends Resource
{
    protected static ?string $model = Prescription::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    protected static ?string $navigationGroup = 'Pharmacy';


public static function form(Form $form): Form
{
    return $form
        ->schema([
                        Forms\Components\TextInput::make('prescription_code')
                        ->required(),
Forms\Components\Select::make('examination_code')
    ->relationship('examination', 'examination_code')
    ->required()
    ->columnSpanFull(),


            Forms\Components\Textarea::make('instructions')
                ->required()
                ->columnSpanFull(), // memanjang penuh

            Forms\Components\Repeater::make('prescriptionMedicines')
                ->relationship()
                ->schema([
                    Forms\Components\Select::make('medicine_code')
                        ->relationship('medicine', 'name')
                        ->required(),
                    Forms\Components\TextInput::make('quantity')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('dosage')
                        ->required(),
                ])
                ->columns(3) // repeater ini punya 3 kolom, isinya medicine, quantity, dosage
                ->columnSpanFull() // repeater memanjang penuh agar rata
                // ->required(),
        ])
        ->columns(3); // form utama pakai 3 kolom
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
Tables\Columns\TextColumn::make('examination.examination_code')
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
                Tables\Actions\DeleteAction::make()
                    // ->before(function ($record) {
                    //     // Kembalikan stock sebelum delete
                    //     foreach ($record->prescriptionMedicines as $prescriptionMedicine) {
                    //         $medicine = Medicine::find($prescriptionMedicine->medicine_id);
                    //         if ($medicine) {
                    //             $medicine->increment('stock', $prescriptionMedicine->quantity);
                    //         }
                    //     }
                    // }),
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
            'index' => Pages\ListPrescriptions::route('/'),
            'create' => Pages\CreatePrescription::route('/create'),
            'edit' => Pages\EditPrescription::route('/{record}/edit'),
        ];
    }
}
