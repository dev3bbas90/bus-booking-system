<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;
    protected $fillable = [
        'plate_number'
    ];

    /**
     * Returns bus's seats
     *
     * @return HasMany
     */
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    /**
     * Returns bus's trips
     *
     * @return HasMany
     */
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
