<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicineResource\Pages;
use App\Filament\Resources\MedicineResource\RelationManagers;
use App\Models\Medicine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MedicineResource extends Resource
{
    protected static ?string $model = Medicine::class;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';
    protected static ?string $navigationGroup = 'Pharmacy';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('medicine_code')
                    ->label('Kode Obat')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->placeholder('MED001')
                    ->helperText('Masukkan kode obat unik (contoh: MED001, PARA001, dll)'),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Obat')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Paracetamol'),
                Forms\Components\Select::make('type')
                    ->label('Jenis Obat')
                    ->options([
                        'tablet' => 'Tablet',
                        'kapsul' => 'Kapsul',
                        'sirup' => 'Sirup',
                        'injeksi' => 'Injeksi',
                        'salep' => 'Salep',
                        'tetes' => 'Tetes',
                        'inhaler' => 'Inhaler',
                        'suppositoria' => 'Suppositoria',
                        'lainnya' => 'Lainnya'
                    ])
                    ->searchable()
                    ->placeholder('Pilih jenis obat'),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull()
                    ->rows(3)
                    ->placeholder('Deskripsi obat, dosis, efek samping, dll'),
                Forms\Components\TextInput::make('stock')
                    ->label('Stok')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->suffix('unit')
                    ->placeholder('0'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('medicine_code')
                    ->label('Kode Obat')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Kode obat disalin!')
                    ->copyMessageDuration(1500),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Obat')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'tablet' => 'success',
                        'kapsul' => 'info',
                        'sirup' => 'warning',
                        'injeksi' => 'danger',
                        'salep' => 'primary',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->sortable()
                    ->color(fn (int $state): string => match (true) {
                        $state <= 10 => 'danger',
                        $state <= 50 => 'warning',
                        default => 'success',
                    })
                    ->badge()
                    ->suffix(' unit'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(30)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Jenis Obat')
                    ->options([
                        'tablet' => 'Tablet',
                        'kapsul' => 'Kapsul',
                        'sirup' => 'Sirup',
                        'injeksi' => 'Injeksi',
                        'salep' => 'Salep',
                        'tetes' => 'Tetes',
                        'inhaler' => 'Inhaler',
                        'suppositoria' => 'Suppositoria',
                        'lainnya' => 'Lainnya'
                    ])
                    ->multiple(),
                Tables\Filters\Filter::make('low_stock')
                    ->label('Stok Rendah')
                    ->query(fn (Builder $query): Builder => $query->where('stock', '<=', 10))
                    ->toggle(),
                Tables\Filters\Filter::make('out_of_stock')
                    ->label('Stok Habis')
                    ->query(fn (Builder $query): Builder => $query->where('stock', '=', 0))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name', 'asc');
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
            'index' => Pages\ListMedicines::route('/'),
            'create' => Pages\CreateMedicine::route('/create'),
            'edit' => Pages\EditMedicine::route('/{record}/edit'),
        ];
    }
}