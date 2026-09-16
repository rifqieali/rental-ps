<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    protected $fillable = [
        'name',
        'type',
        'room',
        'status',
    ];

    public function ratePackages(): HasMany
    {
        return $this->hasMany(RatePackage::class, 'unit_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'unit_id');
    }
}
