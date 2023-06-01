<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Seat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Seat::truncate();
        Bus::truncate();
        Schema::enableForeignKeyConstraints();

        $bus = Bus::factory(1)->create()[0];

        for ($i = 1; $i <= 14; $i++) {
            Seat::create([
                'bus_id'    => $bus->id,
                'seat_code' => 'Seat-' . sprintf("%02d", $i),
            ]);
        }
    }
}
