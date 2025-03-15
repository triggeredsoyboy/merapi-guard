<?php

namespace App\Filament\Resources\EruptionHistoryResource\Pages;

use App\Filament\Resources\EruptionHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditEruptionHistory extends EditRecord
{
    protected static string $resource = EruptionHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Success')
                        ->body('The history has been deleted successfully.'),
                ),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Updated')
            ->body('The history has been saved successfully.');
    }
}
