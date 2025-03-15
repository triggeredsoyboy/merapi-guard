<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationGroup = 'News & Articles';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->string()
                                    ->minLength(5)
                                    ->maxLength(100)
                                    ->autocomplete(false)
                                    ->autofocus()
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                                        if (($get('slug') ?? '') !== Str::slug($old)) {
                                            return;
                                        }

                                        $set('slug', Str::slug($state));
                                    }),
                                Forms\Components\Placeholder::make('user.name')
                                    ->label('Author')
                                    ->content(fn(Post $record): ?string => $record->user['name'])
                                    ->visibleOn('view'),
                                Forms\Components\RichEditor::make('excerpt')
                                    ->string()
                                    ->minLength(0)
                                    ->required(),
                            ])
                            ->compact(),
                        Forms\Components\Builder::make('body')
                            ->blocks([
                                Forms\Components\Builder\Block::make('media')
                                    ->schema([
                                        Forms\Components\FileUpload::make('images')
                                            ->image()
                                            ->directory('post-blocks')
                                            ->multiple()
                                            ->reorderable()
                                            ->appendFiles()
                                            ->moveFiles()
                                            ->minFiles(1)
                                            ->maxFiles(4)
                                            ->panelLayout('grid')
                                            ->required(),
                                    ]),
                                Forms\Components\Builder\Block::make('paragraph')
                                    ->schema([
                                        Forms\Components\RichEditor::make('content')
                                            ->string()
                                            ->minLength(0)
                                            ->required(),
                                    ]),
                            ])
                            ->addActionLabel('Add blocks')
                            ->blockNumbers(false)
                            ->required(),
                    ])
                    ->columnSpan(['lg' => 2]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('slug')
                                    ->string()
                                    ->minLength(5)
                                    ->maxLength(100)
                                    ->autocomplete(false)
                                    ->required(),
                                Forms\Components\Toggle::make('is_published')
                                    ->default(true)
                                    ->live(onBlur: true),
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->native(false)
                                    ->seconds(false)
                                    ->timezone('Asia/Jakarta')
                                    ->maxDate(now())
                                    ->displayFormat('j M Y, H:i')
                                    ->disabled(fn(Forms\Get $get): bool => !$get('is_published'))
                                    ->dehydrated(fn(?string $state): bool => filled($state))
                                    ->required(fn(Forms\Get $get): bool => $get('is_published')),
                                Forms\Components\Select::make('category_id')
                                    ->native(false)
                                    ->relationship(name: 'category', titleAttribute: 'name')
                                    ->preload()
                                    ->required(),
                            ])
                            ->compact(),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->content(fn(Post $record): ?string => $record->created_at?->format('j M Y, H:i')),
                                Forms\Components\Placeholder::make('updated_at')
                                    ->content(fn(Post $record): ?string => $record->created_at?->format('j M Y, H:i')),
                            ])
                            ->compact()
                            ->hidden(fn(?Post $record) => $record === null),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->placeholder('This post isn\'t published yet.')
                    ->dateTime('j M Y, H:i'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('j M Y, H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->icon(''),
                    Tables\Actions\DeleteAction::make()
                        ->icon('')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Success')
                                ->body('The post has been deleted successfully.'),
                        ),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->icon('')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Success')
                            ->body('The selected posts has been deleted successfully.'),
                    ),
            ])
            ->recordUrl(
                fn(Post $record): string => route('filament.admin.resources.posts.view', ['record' => $record]),
            );
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
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
