<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Activity;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ActivityResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ActivityResource\RelationManagers;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'Health';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('FIT File')
                    ->schema([
                        FileUpload::make('file')
                        ->maxFiles(1)
                        ->directory('activities')
                        ->preserveFilenames()
                        ->columnSpanFull(),
                        Forms\Components\Toggle::make('stationary'),
                    ]),

                Forms\Components\TextInput::make('title')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\MarkdownEditor::make('content')
                    ->fileAttachmentsDirectory('images/activities')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('started_at'),
                Forms\Components\TextInput::make('sport')
                    ->maxLength(255),
                Forms\Components\TextInput::make('subsport')
                    ->maxLength(255),

                Forms\Components\TextInput::make('total_elapsed_time')
                    ->numeric(),
                Forms\Components\TextInput::make('total_timer_time')
                    ->numeric(),
                Forms\Components\TextInput::make('avg_speed')
                    ->numeric(),
                Forms\Components\TextInput::make('max_speed')
                    ->numeric(),
                Forms\Components\TextInput::make('total_distance')
                    ->numeric(),
                Forms\Components\TextInput::make('avg_cadence')
                    ->numeric(),
                Forms\Components\TextInput::make('max_cadence')
                    ->numeric(),
                Forms\Components\TextInput::make('avg_power')
                    ->numeric(),
                Forms\Components\TextInput::make('max_power')
                    ->numeric(),
                Forms\Components\TextInput::make('avg_heart_rate')
                    ->numeric(),
                Forms\Components\TextInput::make('max_heart_rate')
                    ->numeric(),
                Forms\Components\TextInput::make('total_calories')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('started_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('sport'),
                Tables\Columns\TextColumn::make('total_distance')
                    ->suffix('km'),
                Tables\Columns\IconColumn::make('stationary')
                    ->boolean(),
                Tables\Columns\IconColumn::make('processed_at')
                    ->label('Processed')
                    ->boolean(),
            ])
            ->defaultSort(fn ($query) => $query->orderByRaw('-started_at asc'))
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
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
