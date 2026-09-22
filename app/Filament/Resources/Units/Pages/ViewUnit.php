<?php

namespace App\Filament\Resources\Units\Pages;

use App\Filament\Resources\RatePackages\RatePackageResource;
use App\Filament\Resources\Units\UnitResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ViewUnit extends ViewRecord
{
    protected static string $resource = UnitResource::class;

    protected static ?string $relationship = 'ratePackages';

    protected static ?string $relatedResource = RatePackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('price')->money('IDR'),
                TextColumn::make('duration_minutes')
                    ->headerAction([CreateAction::make()])
                    ->recordAction([EditAction::make(), DeleteAction::make()]),
            ]);
    }
}
