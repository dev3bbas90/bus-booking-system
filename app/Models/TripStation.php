<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripStation extends Model
{
    use HasFactory;
    protected $fillable = [
        'trip_id',
        'station_id',
        'order',
        'arrive_time',
        'take_off_time'
    ];

    /**
     * Returns The trip that passes by this station.
     *
     * @return BelongsTo
    */
    public function trip() :BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * Returns station data
     *
     * @return BelongsTo
    */
    public function station() :BelongsTo
    {
        return $this->belongsTo(Station::class);
    }
}
