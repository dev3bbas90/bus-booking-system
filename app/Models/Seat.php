<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seat extends Model
{
    use HasFactory;
    protected $fillable = [
        'bus_id',
    ];

    /**
     * Get the bus that owns the Seat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }
   /**
    * Get all of the bookings for the Seat
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function bookings(): HasMany
   {
       return $this->hasMany(Booking::class);
   }

   public function getSeatCodeAttribute()
   {
        return 'Seat-' . sprintf("%02d", $this->id);
   }
}
