<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Station::truncate();
        Schema::enableForeignKeyConstraints();
        $stations = [
            'Cairo',
            'Faiyum',
            'Minya',
            'Asyut',
        ];
        foreach ($stations as $station) {
            Station::create([
                'name' => $station,
            ]);
        }
    }
}
