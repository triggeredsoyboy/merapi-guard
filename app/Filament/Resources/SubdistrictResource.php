<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubdistrictResource\Pages;
use App\Filament\Resources\SubdistrictResource\RelationManagers;
use App\Models\Subdistrict;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;

class SubdistrictResource extends Resource
{
    protected static ?string $model = Subdistrict::class;

    protected static ?string $navigationGroup = 'Disaster Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
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
                                Forms\Components\RichEditor::make('description')
                                    ->string()
                                    ->minLength(0),
                            ])
                            ->compact(),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Repeater::make('vulnerability')
                                    ->schema([
                                        Forms\Components\Select::make('type')
                                            ->native(false)
                                            ->options([
                                                'Age Group' => [
                                                    'toddler' => 'Toddler',
                                                    'children' => 'Children',
                                                    'elderly' => 'Elderly',
                                                ],
                                            ])
                                            ->required()
                                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                            ->live(onBlur: true),
                                        Forms\Components\TextInput::make('amount')
                                            ->numeric()
                                            ->minValue(0)
                                            ->maxValue(100000)
                                            ->autocomplete(false)
                                            ->required()
                                    ])
                                    ->columns(['sm' => 2])
                                    ->required()
                                    ->itemLabel(fn(array $state): ?string => Str::title($state['type']) ?? null)
                                    ->addActionLabel('Add more'),
                            ])
                            ->compact()
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
                                Forms\Components\Placeholder::make('created_at')
                                    ->content(fn(Subdistrict $record): ?string => $record->created_at?->format('j M Y, H:i'))
                                    ->hidden(fn(?Subdistrict $record) => $record === null),
                                Forms\Components\Placeholder::make('updated_at')
                                    ->content(fn(Subdistrict $record): ?string => $record->created_at?->format('j M Y, H:i'))
                                    ->hidden(fn(?Subdistrict $record) => $record === null),
                            ])
                            ->compact(),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
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
                                ->body('The subdistrict has been deleted successfully.'),
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
                            ->body('The selected subdistricts has been deleted successfully.'),
                    ),
            ])
            ->recordUrl(
                fn(Subdistrict $record): string => route('filament.admin.resources.subdistricts.view', ['record' => $record]),
            );
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Group::make()
                    ->schema([
                        Infolists\Components\Section::make()
                            ->schema([
                                Infolists\Components\TextEntry::make('name'),
                                Infolists\Components\TextEntry::make('description')
                                    ->placeholder('There\'s no description.')
                                    ->markdown(),
                            ])
                            ->compact(),
                        Infolists\Components\Section::make()
                            ->schema([
                                Infolists\Components\RepeatableEntry::make('vulnerability')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('type')
                                            ->formatStateUsing(fn(string $state): string => Str::title($state) ?? null),
                                        Infolists\Components\TextEntry::make('amount'),
                                    ])
                                    ->columns(['sm' => 2])
                                    ->grid(['sm' => 2]),
                            ])
                            ->compact(),
                    ])
                    ->columnSpan(['lg' => 2]),
                Infolists\Components\Group::make()
                    ->schema([
                        Infolists\Components\Section::make()
                            ->schema([
                                Infolists\Components\TextEntry::make('slug'),
                                Infolists\Components\TextEntry::make('created_at')
                                    ->dateTime('j M Y, H:i'),
                                Infolists\Components\TextEntry::make('updated_at')
                                    ->dateTime('j M Y, H:i'),
                            ])
                            ->compact()
                    ])
                    ->columnSpan(['lg' => 1]),
            ])->columns(3);
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
            'index' => Pages\ListSubdistricts::route('/'),
            'create' => Pages\CreateSubdistrict::route('/create'),
            'view' => Pages\ViewSubdistrict::route('/{record}'),
            'edit' => Pages\EditSubdistrict::route('/{record}/edit'),
        ];
    }
}
