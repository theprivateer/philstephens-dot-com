<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Forms\Components\LivePreview;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Group::make([
                        Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                        ->required()
                                        ->maxLength(255),

                                Forms\Components\TextInput::make('subtitle')
                                    ->maxLength(255),
                            ]),
                        Section::make()
                            ->schema([
                                Forms\Components\MarkdownEditor::make('content')
                                    ->fileAttachmentsDirectory('images/' . date('Ymd'))
                                    ->columnSpanFull(),
                            ]),
                    ]),


                    LivePreview::make(''),
                    // Placeholder::make('')
                    //     ->content(function (Get $get): HtmlString {
                    //         return new HtmlString('
                    //         <iframe src="/" width="100%" height="500px"></iframe>');
                    //     })
                    // Section::make([
                    //     Toggle::make('top_level'),
                    //     Forms\Components\TextInput::make('redirects_to')
                    //                 ->maxLength(255),
                    // ])->grow(false),
                ])->from('md')
            ])->columns(1);
            // ->schema([
            //     Forms\Components\TextInput::make('title')
            //         ->required()
            //         ->maxLength(255),
            //     Forms\Components\TextInput::make('redirects_to')
            //         ->maxLength(255),
            //     Forms\Components\TextInput::make('subtitle')
            //         ->maxLength(255),
            //     Forms\Components\MarkdownEditor::make('content')
            //         ->fileAttachmentsDirectory('images/' . date('Ymd'))
            //         ->columnSpanFull(),
            //     Toggle::make('top_level'),
            // ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->description(fn (Post $record): ?string => $record->subtitle)
                    ->searchable(),
                IconColumn::make('top_level')
                    ->boolean(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
