<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiskLevelResource\Pages;
use App\Filament\Resources\RiskLevelResource\RelationManagers;
use App\Models\RiskLevel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RiskLevelResource extends Resource
{
    protected static ?string $model = RiskLevel::class;

    protected static ?string $navigationIcon = 'carbon-skill-level-basic';

    protected static ?string $navigationGroup = 'Configuraciones de Capas';

    protected static ?int $navigationSort = 5;

    public static function getLabel(): ?string
    {
        return 'Nivel de riesgo';
    }

    public static function getNavigationLabel(): string
    {
        return 'Niveles de riesgo';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nivel de riesgo')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('values')
                    ->label('Valores')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('days_to_add')
                    ->label('Días a añadir')
                    ->required()
                    ->maxLength(50),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nivel de riesgo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('values')
                    ->label('Valores')
                    ->searchable(),
                Tables\Columns\TextColumn::make('days_to_add')
                    ->label('Días a añadir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Creado por')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado el')
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
            'index' => Pages\ListRiskLevels::route('/'),
            'create' => Pages\CreateRiskLevel::route('/create'),
            'edit' => Pages\EditRiskLevel::route('/{record}/edit'),
        ];
    }
}
