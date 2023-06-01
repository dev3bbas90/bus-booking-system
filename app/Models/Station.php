<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Returns all trips schedule passing this station
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trip_stations()
    {
        return $this->hasMany(TripStation::class );
    }
}
