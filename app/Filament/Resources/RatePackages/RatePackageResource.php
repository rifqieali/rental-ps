<?php

namespace App\Filament\Resources\RatePackages;

use App\Filament\Resources\RatePackages\Pages\CreateRatePackage;
use App\Filament\Resources\RatePackages\Pages\EditRatePackage;
use App\Filament\Resources\RatePackages\Pages\ListRatePackages;
use App\Filament\Resources\RatePackages\Pages\ViewRatePackage;
use App\Filament\Resources\RatePackages\Schemas\RatePackageForm;
use App\Filament\Resources\RatePackages\Schemas\RatePackageInfolist;
use App\Filament\Resources\RatePackages\Tables\RatePackagesTable;
use App\Models\RatePackage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RatePackageResource extends Resource
{
    protected static ?string $model = RatePackage::class;

    protected static UnitEnum|string|null $navigationGroup = 'Katalog';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Paket';

    protected static ?string $pluralModelLabel = 'Daftar Paket';

    public static function form(Schema $schema): Schema
    {
        return RatePackageForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RatePackageInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RatePackagesTable::configure($table);
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
            'index' => ListRatePackages::route('/'),
            'create' => CreateRatePackage::route('/create'),
            'view' => ViewRatePackage::route('/{record}'),
            'edit' => EditRatePackage::route('/{record}/edit'),
        ];
    }
}
