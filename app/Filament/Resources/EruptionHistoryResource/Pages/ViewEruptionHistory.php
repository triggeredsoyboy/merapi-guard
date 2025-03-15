<?php

namespace App\Filament\Resources\EruptionHistoryResource\Pages;

use App\Filament\Resources\EruptionHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEruptionHistory extends ViewRecord
{
    protected static string $resource = EruptionHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
