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
        Schema::create('trip_stations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')      ->constrained()->cascadeOnDelete();
            $table->foreignId('station_id')   ->constrained('stations');
            $table->timestamp('arrive_time')  ->nullable();
            $table->timestamp('take_off_time')->nullable();
            $table->integer('order')          ->comment("station order in trip way")->default(1);
            $table->unique(['trip_id','station_id','order']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_stations');
    }
};
