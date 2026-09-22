<?php

namespace App\Filament\Resources\RatePackages\Pages;

use App\Filament\Resources\RatePackages\RatePackageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRatePackages extends ListRecords
{
    protected static string $resource = RatePackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah Paket'),
        ];
    }
}
