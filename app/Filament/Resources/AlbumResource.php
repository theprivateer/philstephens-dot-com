<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Album;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AlbumResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AlbumResource\RelationManagers;

class AlbumResource extends Resource
{
    protected static ?string $model = Album::class;

    protected static ?string $navigationIcon = 'heroicon-o-speaker-wave';

    protected static ?string $navigationGroup = 'Collections';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('artist')
                    ->maxLength(255),
                FileUpload::make('album_artwork')
                    ->image()
                    ->maxFiles(1)
                    ->directory('images/365albums')
                    ->preserveFilenames()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('released')
                    ->maxLength(255),
                Forms\Components\TextInput::make('listen_link')
                    ->maxLength(255),
                Forms\Components\MarkdownEditor::make('content')
                    ->fileAttachmentsDirectory('images/365albums')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('published_at')
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('album_artwork')
                    ->label('Artwork'),
                Tables\Columns\TextColumn::make('title')
                    ->description(fn (Album $record): string => $record->artist)
                    ->searchable(),
                Tables\Columns\TextColumn::make('artist')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->postStatus(),
                Tables\Columns\TextColumn::make('published_at')
                    ->date()
                    ->sortable(),
            ])
            ->defaultSort(fn ($query) => $query->orderByRaw('-published_at asc'))
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
            'index' => Pages\ListAlbums::route('/'),
            'create' => Pages\CreateAlbum::route('/create'),
            'edit' => Pages\EditAlbum::route('/{record}/edit'),
        ];
    }
}
