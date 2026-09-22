<?php

namespace App\Filament\Resources\Units\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'units', column: 'name', ignoreRecord: true),
                Select::make('type')
                    ->options(['PS3' => 'PS3', 'PS4' => 'PS4', 'PS5' => 'PS5'])
                    ->required(),
                TextInput::make('room')
                    ->required(),
                Select::make('status')
                    ->options(['available' => 'Available', 'occupied' => 'Occupied', 'maintenance' => 'Maintenance'])
                    ->required(),
            ]);
    }
}
