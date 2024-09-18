<?php

namespace App\Filament\Resources\HeartRateZoneResource\Pages;

use App\Filament\Resources\HeartRateZoneResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHeartRateZone extends EditRecord
{
    protected static string $resource = HeartRateZoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
