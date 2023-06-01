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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')                ->constrained();
            $table->foreignId('trip_id')                ->constrained();
            $table->foreignId('seat_id')                ->constrained();
            $table->integer('source_order')          ->default(0);
            $table->integer('destination_order')     ->default(0);
            $table->unique(['trip_id','seat_id', 'source_order', 'destination_order']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
