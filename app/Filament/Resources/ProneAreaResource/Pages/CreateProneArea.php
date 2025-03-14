<?php

namespace App\Filament\Resources\ProneAreaResource\Pages;

use App\Filament\Resources\ProneAreaResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateProneArea extends CreateRecord
{
    protected static string $resource = ProneAreaResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Success')
            ->body('The prone area has been created successfully.');
    }
}
