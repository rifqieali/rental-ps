<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RatePackage extends Model
{
    protected $fillable = [
        'unit_id',
        'name',
        'price',
        'duration_minutes',
        'is_active',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
