<?php

use App\Models\Unit;
use App\Models\User;
use App\Services\BookingService;
use Illuminate\Validation\ValidationException;

it('menolak booking yang beririsan di unit yang sama', function () {
    $unit = Unit::factory()->create();
    $user = User::factory()->create();
    $service = app(BookingService::class);

    $service->create([
        'booking_code' => 'PS-TEST01',
        'user_id' => $user->id,
        'unit_id' => $unit->id,
        'start_at' => now()->addDay()->setTime(19, 0),
        'end_at' => now()->addDay()->setTime(21, 0),
        'status' => 'pending',
        'total_price' => 16000,
    ]);

    expect(fn () => $service->create([
        'booking_code' => 'PS-TEST02',
        'user_id' => $user->id,
        'unit_id' => $unit->id,
        'start_at' => now()->addDay()->setTime(20, 0),
        'end_at' => now()->addDay()->setTime(22, 0),
        'status' => 'pending',
        'total_price' => 16000,
    ]))->toThrow(ValidationException::class);
});

it('meloloskan jam sama di unit berbeda', function () {
    $unitA = Unit::factory()->create();
    $unitB = Unit::factory()->create();
    $user = User::factory()->create();
    $service = app(BookingService::class);

    $service->create([
        'booking_code' => 'PS-TEST03',
        'user_id' => $user->id,
        'unit_id' => $unitA->id,
        'start_at' => now()->addDay()->setTime(20, 0),
        'end_at' => now()->addDay()->setTime(22, 0),
        'status' => 'pending',
        'total_price' => 16000,
    ]);

    $second = $service->create([
        'booking_code' => 'PS-TEST04',
        'user_id' => $user->id,
        'unit_id' => $unitB->id,
        'start_at' => now()->addDay()->setTime(20, 0),
        'end_at' => now()->addDay()->setTime(22, 0),
        'status' => 'pending',
        'total_price' => 16000,
    ]);

    expect($second->exists)->toBeTrue();
});

it('meloloskan slot nempel 19-21 dan 21-23', function () {
    $unit = Unit::factory()->create();
    $user = User::factory()->create();
    $service = app(BookingService::class);

    $service->create([
        'booking_code' => 'PS-TEST05',
        'user_id' => $user->id,
        'unit_id' => $unit->id,
        'start_at' => now()->addDay()->setTime(19, 0),
        'end_at' => now()->addDay()->setTime(21, 0),
        'status' => 'confirmed',
        'total_price' => 16000,
    ]);

    $second = $service->create([
        'booking_code' => 'PS-TEST06',
        'user_id' => $user->id,
        'unit_id' => $unit->id,
        'start_at' => now()->addDay()->setTime(21, 0),
        'end_at' => now()->addDay()->setTime(23, 0),
        'status' => 'pending',
        'total_price' => 16000,
    ]);

    expect($second->exists)->toBeTrue();
});

it('tidak menghalangi slot yang booking lamanya sudah cancelled', function () {
    $unit = Unit::factory()->create();
    $user = User::factory()->create();
    $service = app(BookingService::class);

    $first = $service->create([
        'booking_code' => 'PS-TEST07',
        'user_id' => $user->id,
        'unit_id' => $unit->id,
        'start_at' => now()->addDay()->setTime(19, 0),
        'end_at' => now()->addDay()->setTime(21, 0),
        'status' => 'pending',
        'total_price' => 16000,
    ]);

    $first->update(['status' => 'cancelled']);

    $second = $service->create([
        'booking_code' => 'PS-TEST08',
        'user_id' => $user->id,
        'unit_id' => $unit->id,
        'start_at' => now()->addDay()->setTime(20, 0),
        'end_at' => now()->addDay()->setTime(22, 0),
        'status' => 'pending',
        'total_price' => 16000,
    ]);

    expect($second->exists)->toBeTrue();
});

it('meloloskan edit yang hanya menggeser dirinya sendiri', function () {
    $unit = Unit::factory()->create();
    $user = User::factory()->create();
    $service = app(BookingService::class);

    $booking = $service->create([
        'booking_code' => 'PS-TEST09',
        'user_id' => $user->id,
        'unit_id' => $unit->id,
        'start_at' => now()->addDay()->setTime(19, 0),
        'end_at' => now()->addDay()->setTime(21, 0),
        'status' => 'pending',
        'total_price' => 16000,
    ]);

    $moved = $service->reschedule($booking, [
        'start_at' => now()->addDay()->setTime(21, 0),
        'end_at' => now()->addDay()->setTime(23, 0),
    ]);

    expect($moved->start_at->format('H:i'))->toBe('21:00');
});
