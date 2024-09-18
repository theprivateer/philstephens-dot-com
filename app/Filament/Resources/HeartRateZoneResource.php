<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeartRateZoneResource\Pages;
use App\Filament\Resources\HeartRateZoneResource\RelationManagers;
use App\Models\HeartRateZone;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeartRateZoneResource extends Resource
{
    protected static ?string $model = HeartRateZone::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationGroup = 'Health';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('valid_from')
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('zone_1_max')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('zone_2_max')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('zone_3_max')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('zone_4_max')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('valid_from')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('zone_1_max')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('zone_2_max')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('zone_3_max')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('zone_4_max')
                    ->numeric()
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
            'index' => Pages\ListHeartRateZones::route('/'),
            'create' => Pages\CreateHeartRateZone::route('/create'),
            'edit' => Pages\EditHeartRateZone::route('/{record}/edit'),
        ];
    }
}
