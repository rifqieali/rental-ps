<?php

namespace Database\Seeders;

use App\Models\RatePackage;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Katalog demo kasir: 3 unit (satu per tipe) + 2 paket per unit
     * (reguler per jam + paket hemat), ala kafe PS (ruang Reguler/VIP).
     */
    public function run(): void
    {
        $catalog = [
            [
                'name' => 'PS3-01',
                'type' => 'PS3',
                'room' => 'Reguler',
                'status' => 'available',
                'packages' => [
                    ['name' => 'Reguler 1 Jam', 'price' => 5000, 'duration_minutes' => 60, 'is_active' => true],
                    ['name' => 'Hemat 3 Jam', 'price' => 12000, 'duration_minutes' => 180, 'is_active' => true],
                ],
            ],
            [
                'name' => 'PS4-01',
                'type' => 'PS4',
                'room' => 'Reguler',
                'status' => 'available',
                'packages' => [
                    ['name' => 'Reguler 1 Jam', 'price' => 8000, 'duration_minutes' => 60, 'is_active' => true],
                    ['name' => 'Hemat 3 Jam', 'price' => 20000, 'duration_minutes' => 180, 'is_active' => true],
                ],
            ],
            [
                'name' => 'PS5-VIP-01',
                'type' => 'PS5',
                'room' => 'VIP',
                'status' => 'available',
                'packages' => [
                    ['name' => 'Reguler 1 Jam', 'price' => 15000, 'duration_minutes' => 60, 'is_active' => true],
                    ['name' => 'Hemat 3 Jam', 'price' => 38000, 'duration_minutes' => 180, 'is_active' => true],
                ],
            ],
        ];

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
