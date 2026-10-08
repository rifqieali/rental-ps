<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = User::where('email', 'customer@rental.dev')->firstOrFail();
        $kasir = User::where('email', 'kasir@rental.dev')->first();
        $day = today();

        $slots = [
            ['unit' => 'PS4-01', 'start' => '10:00', 'end' => '12:00', 'status' => 'paid'],
            ['unit' => 'PS4-01', 'start' => '13:00', 'end' => '15:00', 'status' => 'confirmed'],
            ['unit' => 'PS4-01', 'start' => '19:00', 'end' => '21:00', 'status' => 'pending'],
            ['unit' => 'PS4-02', 'start' => '19:00', 'end' => '21:00', 'status' => 'confirmed'],
        ];

        foreach ($slots as $slot) {
            $unit = Unit::where('name', $slot['unit'])->first();

            if (! $unit) {
                continue;
            }

            Booking::updateOrCreate([
                'unit_id' => $unit->id,
                'start_at' => $day->copy()->setTimeFromTimeString($slot['start']),
            ], [
                'booking_code' => 'PS-'.Str::upper(Str::random(6)),
                'user_id' => $customer->id,
                'end_at' => $day->copy()->setTimeFromTimeString($slot['end']),
                'status' => $slot['status'],
                'is_walk_in' => false,
                'total_price' => 16000,
                'handled_by' => $kasir?->id,
            ]);
        }
    }
}
