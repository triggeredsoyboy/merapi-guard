<?php

namespace App\Filament\Resources\EruptionHistoryResource\Pages;

use App\Filament\Resources\EruptionHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEruptionHistories extends ListRecords
{
    protected static string $resource = EruptionHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
