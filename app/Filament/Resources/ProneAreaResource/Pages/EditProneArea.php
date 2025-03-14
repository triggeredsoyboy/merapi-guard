<?php

namespace App\Filament\Resources\ProneAreaResource\Pages;

use App\Filament\Resources\ProneAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditProneArea extends EditRecord
{
    protected static string $resource = ProneAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Success')
                        ->body('The prone area has been deleted successfully.'),
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
            ->body('The prone area has been saved successfully.');
    }
}
