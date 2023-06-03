<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class TripFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function tripId($trip_id)
    {
        return $this->where('trips.id' , $trip_id );
    }

    public function source($source)
    {
        return $this->whereHas('line_stations' , function($query) use ($source)
        {
            $query->where('station_id' , $source );
        });
    }

    public function destination($destination)
    {
        return $this->whereHas('line_stations' , function($query) use ($destination)
        {
            $query->where('station_id' , $destination );
        });
    }

    public function date($date)
    {
        return $this->whereHas('line_stations' , function($query) use ($date)
        {
            $query->whereRaw("date(take_off_time) = '$date' " );
            // $query->where('station_id' , $date );
        });
    }
}
