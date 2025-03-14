<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProneAreaResource\Pages;
use App\Filament\Resources\ProneAreaResource\RelationManagers;
use App\Models\ProneArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProneAreaResource extends Resource
{
    protected static ?string $model = ProneArea::class;

    protected static ?string $navigationGroup = 'Disaster Management';

    protected static ?int $navigationSort = 1;

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
                                    ->content(fn(ProneArea $record): ?string => $record->created_at?->format('j M Y, H:i'))
                                    ->hidden(fn(?ProneArea $record) => $record === null),
                                Forms\Components\Placeholder::make('updated_at')
                                    ->content(fn(ProneArea $record): ?string => $record->created_at?->format('j M Y, H:i'))
                                    ->hidden(fn(?ProneArea $record) => $record === null),
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
                                ->body('The prone area has been deleted successfully.'),
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
                            ->body('The selected prone areas has been deleted successfully.'),
                    ),
            ])
            ->recordUrl(
                fn(ProneArea $record): string => route('filament.admin.resources.prone-areas.view', ['record' => $record]),
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
                            ->compact()
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
            'index' => Pages\ListProneAreas::route('/'),
            'create' => Pages\CreateProneArea::route('/create'),
            'view' => Pages\ViewProneArea::route('/{record}'),
            'edit' => Pages\EditProneArea::route('/{record}/edit'),
        ];
    }
}
