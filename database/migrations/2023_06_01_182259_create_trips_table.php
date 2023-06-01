<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')                 ->constrained()->cascadeOnDelete();
            $table->foreignId('source_station_id')      ->constrained('stations');
            $table->foreignId('destination_station_id') ->constrained('stations');
            $table->timestamp('take_off_time')          ->nullable();
            $table->timestamp('arrive_time')            ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
