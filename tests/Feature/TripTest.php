<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TripTest extends TestCase
{
    use WithoutMiddleware;

    public function test_get_available_trips_with_seats()
    {
        $this->postJson(route('api.trips.available_seats'), [
            'trip_id'                => 1,
            'source_station_id'      => 3,
            'destination_station_id' => 4,
            'date'                   => date('Y-m-d')
        ])
        ->assertSuccessful()
        ->assertJsonStructure([
            'data' =>[
                '*' => [
                    'id',
                    'bus_id',
                    'plate_number',
                    'available_seat' => [
                        '*' =>[
                            'id' ,
                            'code'
                        ]
                    ]
                ]
            ]
        ])
        ->assertJson([
            'message' => "Trip Available Seats"
        ]);
    }

    public function test_check_available_trips_with_invalid_credintials_()
    {
        $this->postJson(route('api.trips.available_seats'), [
            'trip_id'                => 1,
            'source_station_id'      => 3,
            'destination_station_id' => 4,
            'date'                   => Carbon::now()->subDay()
        ])
        ->assertStatus(422)
        ->assertJson([
            'message' => "The date field must be a date after or equal to ".date('Y-m-d') . "."
        ]);
    }


}
