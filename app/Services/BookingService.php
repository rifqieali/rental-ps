<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingService
{
    public function create(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            $this->lockUnit((int) $data['unit_id']);

            return Booking::create($data);
        });
    }

    public function reschedule(Booking $booking, array $data): Booking
    {
        return DB::transaction(function () use ($booking, $data) {
            $this->lockUnit((int) ($data['unit_id'] ?? $booking->unit_id));

            $booking->update($data);

            return $booking->fresh();
        });
    }

    private function lockUnit(int $unitId): void
    {
        $unit = Unit::whereKey($unitId)->lockForUpdate()->first();

        if (! $unit) {
            throw ValidationException::withMessages([
                'unit_id' => 'Unit tidak ditemukan.',
            ]);
        }
    }
}
