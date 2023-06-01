<?php

namespace Database\Factories;

use App\Models\Seat;
use App\Models\Station;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Psy\Util\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bus>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return User::first()->id ?? User::factory()->create()->id;
            },
            'trip_id' => function () {
                return Trip::first()->id;
            },
            'bus_id' => Trip::first()->bus_id,
            'seat_id' => Seat::inRandomOrder()->first(),
            'from_station_id' => function () {
                return Station::first()->id;
            },
            'to_station_id' => function () {
                return Station::latest()->first()->id;
            },
        ];
    }
}
