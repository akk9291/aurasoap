<?php

namespace App\Filament\Resources\DistributorApplications;

use App\Filament\Resources\DistributorApplications\Pages\CreateDistributorApplication;
use App\Filament\Resources\DistributorApplications\Pages\EditDistributorApplication;
use App\Filament\Resources\DistributorApplications\Pages\ListDistributorApplications;
use App\Filament\Resources\DistributorApplications\Schemas\DistributorApplicationForm;
use App\Filament\Resources\DistributorApplications\Tables\DistributorApplicationsTable;
use App\Models\DistributorApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DistributorApplicationResource extends Resource
{
    protected static ?string $model = DistributorApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return DistributorApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DistributorApplicationsTable::configure($table);
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
            'index' => ListDistributorApplications::route('/'),
            'create' => CreateDistributorApplication::route('/create'),
            'edit' => EditDistributorApplication::route('/{record}/edit'),
        ];
    }
}
