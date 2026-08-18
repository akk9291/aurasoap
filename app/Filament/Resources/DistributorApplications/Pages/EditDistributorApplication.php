<?php

namespace App\Filament\Resources\DistributorApplications\Pages;

use App\Filament\Resources\DistributorApplications\DistributorApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDistributorApplication extends EditRecord
{
    protected static string $resource = DistributorApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
