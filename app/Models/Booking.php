<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'trip_id',
        'seat_id',
        'source_order',
        'destination_order'
    ];

    /**
     * Returns trip
     *
     * @return BelongsTo
    */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * Returns User
     *
     * @return BelongsTo
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns Bus
     *
     * @return HasOneThrough
    */
    public function bus(): HasOneThrough
    {
        return $this->hasOneThrough(Bus::class , Trip::class);
    }

    /**
     * Returns Seat
     *
     * @return BelongsTo
    */
    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    /**
     * Returns source (start point)
     *
     * @return BelongsTo
    */
    public function source_station(): BelongsTo
    {
        return $this->belongsTo(TripStation::class, 'source_order' , 'order')->where('trip_stations.trip_id' , $this->trip_id);
    }

    /**
     * Returns source (end point)
     *
     * @return BelongsTo
    */
    public function destination_station(): BelongsTo
    {
        return $this->belongsTo(TripStation::class, 'destination_order' , 'order')->where('trip_stations.trip_id' , $this->trip_id);
    }
}
