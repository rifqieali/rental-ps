<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            CatalogSeeder::class,
        ]);

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@rental.dev',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('admin');

        $kasir = User::factory()->create([
            'name' => 'Kasir Demo',
            'email' => 'kasir@rental.dev',
            'password' => bcrypt('password'),
        ]);

        $kasir->assignRole('kasir');

        $customer = User::factory()->create([
            'name' => 'Customer Demo',
            'email' => 'customer@rental.dev',
            'password' => bcrypt('password'),
        ]);

        $customer->assignRole('customer');
    }
}
