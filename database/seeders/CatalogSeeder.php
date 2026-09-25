<?php

namespace Database\Seeders;

use App\Models\RatePackage;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CatalogSeeder extends Seeder
{
    /**
     * Katalog demo kasir: 3 unit (satu per tipe) + 2 paket per unit
     * (reguler per jam + paket hemat), ala kafe PS (ruang Reguler/VIP).
     */
    public function run(): void
    {
        $json = File::get(database_path('data/catalogs.json'));
        $catalog = json_decode($json, true);

        foreach ($catalog as $unitData) {
            $unit = Unit::updateOrCreate(
                ['name' => $unitData['name']],
                [
                    'type' => $unitData['type'],
                    'room' => $unitData['room'],
                    'status' => $unitData['status'],
                ]
            );

            foreach ($unitData['packages'] as $packageData) {
                RatePackage::updateOrCreate(
                    ['unit_id' => $unit->id, 'name' => $packageData['name']],
                    [
                        'price' => $packageData['price'],
                        'duration_minutes' => $packageData['duration_minutes'],
                        'is_active' => $packageData['is_active'],
                    ]
                );
            }
        }
    }
}
