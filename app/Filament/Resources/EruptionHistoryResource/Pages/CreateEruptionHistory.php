<?php

namespace App\Filament\Resources\EruptionHistoryResource\Pages;

use App\Filament\Resources\EruptionHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateEruptionHistory extends CreateRecord
{
    protected static string $resource = EruptionHistoryResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Success')
            ->body('The history has been created successfully.');
    }
}
