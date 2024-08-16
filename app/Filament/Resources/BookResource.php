<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Book;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BookResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BookResource\RelationManagers;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Collections';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('author')
                    ->maxLength(255)
                    ->datalist(function () {
                        return Book::get()->pluck('author')->unique()->all();
                    }),
                Forms\Components\TextInput::make('subtitle')
                    ->maxLength(255),
                Select::make('genre')
                    ->required()
                    ->options([
                        'Fiction' => 'Fiction',
                        'Non-Fiction' => 'Non-Fiction',
                    ]),
                Forms\Components\TextInput::make('series')
                    ->maxLength(255)
                    ->datalist(function () {
                        return Book::get()->pluck('series')->unique()->all();
                    }),
                Forms\Components\TextInput::make('series_number')
                    ->integer(),
                FileUpload::make('cover_artwork')
                    ->image()
                    ->maxFiles(1)
                    ->directory('images/books')
                    ->preserveFilenames()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('link')
                    ->url()
                    ->maxLength(255),
                Forms\Components\MarkdownEditor::make('content')
                    ->fileAttachmentsDirectory('images/books')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('published_at')
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->description(fn (Book $record): string => $record->author)
                    ->searchable(),
                Tables\Columns\TextColumn::make('author')
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
