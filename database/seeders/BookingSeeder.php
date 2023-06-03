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

        for ($i = 1; $i <= 12; $i++) {
            Booking::create([
                'user_id'              => 1,
                'trip_id'              => 1,
                'seat_id'              => $i,
                'source_order'         => 1,
                'destination_order'    => 3,
            ]);
        }
    }
}
