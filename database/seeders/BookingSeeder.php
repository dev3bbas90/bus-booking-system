<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Booking::truncate();
        Schema::enableForeignKeyConstraints();

        Booking::createMany([
            [
                'user_id'              => 1,
                'trip_id'              => 1,
                'seat_id'              => 1,
                'source_order_id'      => 1,
                'destination_order_id' => 2,
            ],
            [
                'user_id'              => 2,
                'trip_id'              => 1,
                'seat_id'              => 1,
                'source_order_id'      => 2,
                'destination_order_id' => 3,
            ]
        ]);
    }
}
