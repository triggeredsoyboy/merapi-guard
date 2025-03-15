<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EruptionHistoryResource\Pages;
use App\Filament\Resources\EruptionHistoryResource\RelationManagers;
use App\Models\EruptionHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

class EruptionHistoryResource extends Resource
{
    protected static ?string $model = EruptionHistory::class;

    protected static ?string $navigationGroup = 'Disaster Management';

    protected static ?int $navigationSort = 3;

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
                                    ->required(),
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
                                Forms\Components\DatePicker::make('happened_at')
                                    ->native(false)
                                    ->timezone('Asia/Jakarta')
                                    ->maxDate(now())
                                    ->displayFormat('j M Y')
                                    ->required(),
                                Forms\Components\Placeholder::make('created_at')
                                    ->content(fn(EruptionHistory $record): ?string => $record->created_at?->format('j M Y, H:i'))
                                    ->hidden(fn(?EruptionHistory $record) => $record === null),
                                Forms\Components\Placeholder::make('updated_at')
                                    ->content(fn(EruptionHistory $record): ?string => $record->created_at?->format('j M Y, H:i'))
                                    ->hidden(fn(?EruptionHistory $record) => $record === null),
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
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('happened_at')
                    ->dateTime('j M Y'),
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
                                ->body('The history has been deleted successfully.'),
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
                            ->body('The selected histories has been deleted successfully.'),
                    ),
            ])
            ->recordUrl(
                fn(EruptionHistory $record): string => route('filament.admin.resources.eruption-histories.view', ['record' => $record]),
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
                                Infolists\Components\TextEntry::make('title'),
                                Infolists\Components\TextEntry::make('happened_at')
                                    ->dateTime('j M Y'),
                            ])
                            ->compact(),
                        Infolists\Components\Section::make()
                            ->schema([
                                Infolists\Components\TextEntry::make('description')
                                    ->placeholder('There\'s no description.')
                                    ->markdown(),
                            ])
                            ->compact(),
                    ])
                    ->columnSpan(['lg' => 2]),
                Infolists\Components\Group::make()
                    ->schema([
                        Infolists\Components\Section::make()
                            ->schema([
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
            'index' => Pages\ListEruptionHistories::route('/'),
            'create' => Pages\CreateEruptionHistory::route('/create'),
            'view' => Pages\ViewEruptionHistory::route('/{record}'),
            'edit' => Pages\EditEruptionHistory::route('/{record}/edit'),
        ];
    }
}
