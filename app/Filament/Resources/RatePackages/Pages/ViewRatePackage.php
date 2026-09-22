<?php

namespace App\Filament\Resources\RatePackages\Pages;

use App\Filament\Resources\RatePackages\RatePackageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRatePackage extends ViewRecord
{
    protected static string $resource = RatePackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
