<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\RatePackage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookingObserver
{
    public function creating(Booking $booking): void
    {
        if (empty($booking->booking_code)) {
            $booking->booking_code = 'PS-'.Str::upper(Str::random(6));
        }
    }

    public function saving(Booking $booking): void
    {
        $this->guardNoOverlap($booking);

        if ($booking->exists && ! $booking->isDirty(['rate_package_id', 'start_at', 'end_at'])) {
            return;
        }

        if (empty($booking->rate_package_id) || empty($booking->start_at) || empty($booking->end_at)) {
            return;
        }

        $paket = RatePackage::find($booking->rate_package_id);

        if (! $paket || empty($paket->duration_minutes)) {
            return;
        }

        $menit = $booking->start_at->diffInMinutes($booking->end_at);

        if ($menit <= 0) {
            return;
        }

        $booking->total_price = ceil($menit / $paket->duration_minutes) * $paket->price;
    }

    private function guardNoOverlap(Booking $booking): void
    {
        if (empty($booking->unit_id) || empty($booking->start_at) || empty($booking->end_at)) {
            return;
        }

        if (! in_array($booking->status ?? 'pending', ['pending', 'confirmed', 'paid'], true)) {
            return;
        }

        if ($booking->exists && ! $booking->isDirty(['unit_id', 'start_at', 'end_at', 'status'])) {
            return;
        }

        if ($booking->end_at <= $booking->start_at) {
            throw ValidationException::withMessages([
                'end_at' => 'Jam akhir harus sesudah dari jam mulai.',
            ]);
        }

        $overlap = Booking::where('unit_id', $booking->unit_id)
            ->whereIn('status', ['pending', 'confirmed', 'paid'])
            ->where('start_at', '<', $booking->end_at)
            ->where('end_at', '>', $booking->start_at)
            ->when($booking->exists, fn ($query) => $query->where('id', '!=', $booking->id))
            ->exists();

        if ($overlap) {
            throw ValidationException::withMessages([
                'start_at' => 'Slot sudah terisi di unit ini.',
            ]);
        }
    }
}
