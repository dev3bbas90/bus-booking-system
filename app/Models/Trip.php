<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Trip extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'bus_id',
        'source_station_id',
        'destination_station_id',
        'take_off_time',
        'arrive_time',
    ];
    /**
     * Returns the bus of the trip.
     *
     * @return BelongsTo
     */
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    /**
     * Returns the destination station hole trip.
     *
     * @return BelongsTo
     */
    public function source()
    {
        return $this->belongsTo(Station::class, 'source_station_id');
    }

    /**
     * Returns the station hole trip.
     *
     * @return BelongsTo
     */
    public function destination()
    {
        return $this->belongsTo(Station::class, 'destination_station_id');
    }

    /**
     * Returns all the line stations of a trip
     *
     * @return HasMany
     */
    public function line_stations()
    {
        return $this->hasMany(TripStation::class)->orderBy('order', 'asc');
    }

    /**
     * Returns all the stations of a trip
     *
     * @return HasManyThrough
     */
    public function stations():HasManyThrough
    {
        return $this->hasManyThrough(Station::class , TripStation::class )->orderBy('trip_stations.order', 'asc');
    }

    /**
     * Returns bookings on this trip
     *
     * @return HasMany
     */
    public function bookings() :HasMany
    {
        return $this->hasMany(Booking::class);
    }

}
