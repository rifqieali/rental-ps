<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\RatePackage;
use Illuminate\Support\Str;

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
}
