<?php

namespace Tests\Feature;

use App\Models\Booking;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use WithoutMiddleware;
    public function booking_a_seat()
    {
        $this->postJson(route('api.bookings.store'), [
            'trip_id'                => 1,
            'seat_id'                => 10,
            'source_station_id'      => 3,
            'destination_station_id' => 4,
        ])
        ->assertSuccessful()
        ->assertJson([
            'message' => "booking Stored Successfully"
        ]);
    }


    public function test_get_booking_data(): void
    {

        $response = $this->get(route('api.bookings.show' , Booking::first()?->id ?? 0));

        $response->assertStatus(200);
    }

}
