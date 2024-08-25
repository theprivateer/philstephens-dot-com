<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Activity;
use Filament\Forms\Form;
use Carbon\CarbonInterval;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
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
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sport')->sport(),
                Tables\Columns\TextColumn::make('total_distance')
                    ->formatStateUsing(function ($state) {
                        return number_format($state, 2) . 'km';
                    })
                    ->summarize(
                        Sum::make()
                            ->label('Total')
                            ->formatStateUsing(function ($state) {
                                return number_format($state) . 'km';
                            })
                    ),
                Tables\Columns\TextColumn::make('total_timer_time')
                    ->label('Duration')
                    ->formatStateUsing(function ($state) {
                        return CarbonInterval::create(
                            0, 0, 0, 0, 0, 0, $state
                        )->cascade()->forHumans(['short' => true, 'parts' => 2]);
                    })
                    ->summarize(
                        Sum::make()
                            ->label('Total')
                            ->formatStateUsing(function ($state) {
                                return CarbonInterval::create(
                                    0, 0, 0, 0, 0, 0, $state
                                )->cascade()->forHumans(['short' => true, 'parts' => 2]);
                            })
                    ),
                Tables\Columns\IconColumn::make('stationary')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\IconColumn::make('processed_at')
                //     ->label('Processed')
                //     ->boolean(),
            ])
            ->defaultSort(fn ($query) => $query->orderByRaw('-started_at asc'))
            ->filters([
                SelectFilter::make('sport')
                    ->options([
                        'cycling' => 'Cycling',
                        'running' => 'Running',
                        'walking' => 'Walking',
                    ]),
                Filter::make('started_at')
                    ->form([
                        DatePicker::make('started_from')->native(false),
                        DatePicker::make('started_until')->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['started_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('started_at', '>=', $date),
                            )
                            ->when(
                                $data['started_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('started_at', '<=', $date),
                            );
                    })
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
