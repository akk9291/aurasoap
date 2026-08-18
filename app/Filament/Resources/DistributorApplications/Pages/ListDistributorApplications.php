<?php

namespace App\Filament\Resources\DistributorApplications\Pages;

use App\Filament\Resources\DistributorApplications\DistributorApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDistributorApplications extends ListRecords
{
    protected static string $resource = DistributorApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
