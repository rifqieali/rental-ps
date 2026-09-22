<?php

namespace App\Filament\Resources\RatePackages\Pages;

use App\Filament\Resources\RatePackages\RatePackageResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRatePackage extends EditRecord
{
    protected static string $resource = RatePackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
