<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Unit::class;

    public function definition(): array
    {
        return [
            'name' => 'UNIT-'.$this->faker->unique()->bothify('??-###'),
            'type' => 'PS4',
            'room' => 'Reguler',
            'status' => 'available',
        ];
    }
}
