<?php

namespace App\Filament\Resources\Units\RelationManagers;

use App\Filament\Resources\RatePackages\RatePackageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RatePackagesRelationManager extends RelationManager
{
    protected static string $relationship = 'ratePackages';

    protected static ?string $relatedResource = RatePackageResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()->label('Tambah Paket'),
            ])
            ->columns([
                TextColumn::make('name')
                    ->label('Paket')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->money('IDR', locale: 'id')
                    ->label('Harga')
                    ->sortable(),
                TextColumn::make('duration_minutes')
                    ->label('Durasi (menit)')
                    ->numeric()
                    ->sortable(),
            ]);
    }
}
