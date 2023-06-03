<?php

namespace App\Http\Traits;

use App\Models\Trip;
use Illuminate\Support\Facades\DB;

trait SeatsAvailability
{
    public function SeatsAvailability($request)
    {
        $source         = $request->source      ?? $request->source_station_id ;
        $destination    = $request->destination ?? $request->destination_station_id ;
        $trips =  Trip::
            when($request->trip_id , function($query) use($request){
                $query->where('trips.id' , $request->trip_id);
            })

            ->when($request->seat_id , function($query) use($request){
                $query->where('seats.id' , $request->seat_id);
            })

            ->select(
                'trips.id as id',
                'buses.id as bus_id',
                'buses.plate_number as plate_number',
                'seats.id as seat_id',
                DB::raw('IFNULL(bookings.booked, 0) as booked'),
                DB::raw("(SELECT CASE WHEN Count(id) > 0 THEN 1 ELSE 0 END from trip_stations where trip_stations.trip_id = trips.id and trip_stations.station_id between $source AND $destination ) as right_way ")
            )
            ->leftJoin('seats', 'seats.bus_id', '=', 'trips.bus_id')
            ->leftJoin('buses', 'buses.id', '=', 'trips.bus_id')
            ->leftJoin(
                DB::raw("
                    (
                        SELECT
                            bookings.*, MIN(trip_stations.order) as min_order,
                            MAX(trip_stations.order) as max_order,
                            CASE WHEN MIN(trip_stations.order) BETWEEN bookings.source_order AND bookings.destination_order-1 OR MAX(trip_stations.order) BETWEEN bookings.source_order+1 AND bookings.destination_order THEN 1 ELSE 0 END as booked
                        FROM
                        (
                            SELECT
                                seats.id as seat_id,
                                bookings.trip_id as trip_id,
                                bookings.source_order,
                                bookings.destination_order
                            FROM seats
                            LEFT JOIN bookings
                                ON bookings.seat_id = seats.id
                        ) as bookings
                        LEFT JOIN
                            trip_stations
                        ON
                            bookings.trip_id = trip_stations.trip_id
                        WHERE
                            trip_stations.station_id BETWEEN $source AND $destination
                        GROUP BY
                            seat_id, trip_id, source_order, destination_order
                        HAVING
                            booked > 0 and source_order < destination_order
                    )
                    as bookings
                "),
                function ($join){
                    $join   ->on('bookings.trip_id', '=', 'trips.id')
                            ->on('bookings.seat_id', '=', 'seats.id');
                }
            )
            ->groupBy('trips.id', 'seats.id')
            ->having('right_way' , '>' , 0)
            ->get()
        ;

        if($request->seat_id){
            return $trips->first();
        }
        return $trips->where('booked' , 0)->groupBy('id');
    }
}


