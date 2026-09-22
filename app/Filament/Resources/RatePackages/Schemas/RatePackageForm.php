<?php

namespace App\Filament\Resources\RatePackages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RatePackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('unit_id')
                    ->relationship('unit', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->prefix('Rp'),
                TextInput::make('duration_minutes')
                    ->required()
                    ->minValue(1)
                    ->numeric(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
