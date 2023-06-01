<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Trip;
use App\Models\TripStation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
    */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Trip::truncate();
        TripStation::truncate();
        Schema::enableForeignKeyConstraints();
        $bus = Bus::find(1);
        if (!$bus) { return; }

        $date    =  date('Y-m-d H:i:s');
        $start   =  date('Y-m-d H:i:s'  ,   strtotime($date.'+2 hour')  );

        $trip = $bus->trips()->create([
            'source_station_id'      => 1,
            'destination_station_id' => 4,
            'take_off_time'          => $start,
            'arrive_time'            => date('Y-m-d H:i:s'  ,   strtotime($start.'+3 hour +45 minutes')  ),
        ]);

        $arrive      =   date('Y-m-d H:i:s',strtotime($start . "-1 hour"));
        foreach ([1,2,3,4] as $i => $station_id)
        {
            $start   = date('Y-m-d H:i:s',strtotime($arrive . "+1 hour"));
            $arrive  = date('Y-m-d H:i:s',strtotime($start . "+15 minutes"));

            $trip->trip_stations_line()->create([
                'station_id'    => $station_id,
                'order'         => ++ $i,
                'arrive_time'   => $start,
                'take_off_time' => $station_id < 4 ? $arrive : null,
            ]);
        }
    }
}
