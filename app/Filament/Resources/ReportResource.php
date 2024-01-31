<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssociatedVulnerabilityResource\RelationManagers\AssociatedVulnerabilitiesRelationManager;
use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'carbon-report';

    protected static ?string $navigationGroup = 'Gestión de vulnerabilidades';

    protected static ?int $navigationSort = 9;

    public static function getLabel(): ?string
    {
        return 'Informe';
    }

    public static function getNavigationLabel(): string
    {
        return 'Informes';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre informe')
                    ->required()
                    ->maxLength(255),
                Select::make('source_id')
                    ->label('Fuente')
                    ->preload()
                    ->relationship('source', 'name', fn (Builder $query) => $query->orderBy('id', 'ASC')),
                Forms\Components\DatePicker::make('detected_at')
                    ->label('Fecha detección')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre informe')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Creado por')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('source.name')
                    ->label('Fuente')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('detected_at')
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
            AssociatedVulnerabilitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
