<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetResource\Pages;
use App\Filament\Resources\AssetResource\RelationManagers;
use App\Models\Asset;
use App\Models\Network;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Select;
use App\Enums\Criticality;

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static ?string $navigationGroup = 'Gestión de dispositivos';

    protected static ?int $navigationSort = 4;

    public static function getLabel(): ?string
    {
        return 'Activo';
    }

    public static function getNavigationLabel(): string
    {
        return 'Activos';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Activo')
                    ->required()
                    ->maxLength(64),
                Forms\Components\TextInput::make('ip_address')
                    ->label('Dirección IP / URL')
                    ->required()
                    ->maxLength(64),
                Forms\Components\TextInput::make('description')
                    ->label('Descripción')
                    ->nullable()
                    ->maxLength(256),
                Forms\Components\TextInput::make('operating_system')
                    ->label('Sistema Operativo')
                    ->nullable()
                    ->maxLength(128),
                Forms\Components\TextInput::make('type')
                    ->label('Tipo')
                    ->required()
                    ->maxLength(64),
                Select::make('criticality')
                    ->label('Criticidad')
                    ->options(Criticality::allForSelect()),
                Select::make('network_id')
                    ->label('Red')
                    ->preload()
                    ->relationship('network', 'name', fn (Builder $query) => $query->orderBy('id', 'ASC')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Creado por')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')
                    ->label('Activo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('Dirección IP / URL')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('criticality')
                    ->label('Criticidad')
                    ->formatStateUsing(fn (string $state): string => Criticality::{$state}->label()),
                Tables\Columns\TextColumn::make('network.name')
                    ->label('Red')
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
                SelectFilter::make('id')
                    ->label('Activo')
                    ->multiple()
                    ->options(fn (): array => Asset::query()->pluck('name', 'id')->all()),
                SelectFilter::make('network_id')
                    ->label('Red')
                    ->multiple()
                    ->options(fn (): array => Network::query()->pluck('name', 'id')->all()),
                SelectFilter::make('criticality')
                    ->label('Criticidad')
                    ->multiple()
                    ->options(fn (): array => Criticality::allForSelect()),
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
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
        ];
    }
}
