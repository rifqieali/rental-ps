<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Booking::class;

    public function definition(): array
    {
        $start = now()->addDay()->setTime(19, 0);

        return [
            'booking_code' => 'PS-'.Str::upper(Str::random(6)),
            'user_id' => User::factory(),
            'unit_id' => Unit::factory(),
            'rate_package_id' => null,
            'start_at' => $start,
            'end_at' => (clone $start)->setTime(21, 0),
            'status' => 'pending',
            'is_walk_in' => false,
            'total_price' => 16000,
        ];
    }
}
