<?php

namespace App\Http\Traits;

use App\Models\Booking;
use App\Models\Trip;
use App\Models\TripStation;
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

    public function SeatsAvailabilityV2($request , $response_type = 'object')
    {
        $source         =   $request->source      ?? $request->source_station_id ;
        $destination    =   $request->destination ?? $request->destination_station_id ;
        $trip_id        =   $request->trip_id;
        $date           =   $request->date;
        $seat_id        =   $request->seat_id;

        // get trip stations that matches query stations and trip id (wanted reservation)
        $trip_stations = TripStation::when($trip_id , function($station) use($trip_id) {
            $station->where('trip_id' , $trip_id);
        })
        ->whereRaw("date(arrive_time) = '$date'")->whereBetween('station_id' , [$source,$destination])
        ;

        $trips = Trip::whereIn('id' , $trip_stations->pluck('trip_id') -> toArray())->get();

        // get start order and end order for stations to check if any seat reserved between them
        $min_line_order = $trip_stations->min('order');
        $max_line_order = $trip_stations->max('order');

        // check any seat reserved between 2 selected points
        $bookings = Booking::
            whereBetween('source_order'      ,  [$min_line_order , $max_line_order-1])
            ->orWhereBetween('destination_order' ,  [$min_line_order+1 , $max_line_order])
        ->get(['trip_id' , 'seat_id']);


        // if you query particular seat return it only
        /*
            response in this case
            -1 => not found in trip
            1 => booked
            0 => available
        */
        if( $trip_id && $seat_id ){
            $trip     = $trips->first();
            $bus      = $trip?->bus;
            $is_found = $bus?->seats?->find($seat_id);

            if(!$is_found){
                return $response_type == 'value' ? -1 : [];
            }

            $is_booked  =  $bookings->where('trip_id' , $trip_id)->where('seat_id' , $seat_id)->count();
            if($response_type == 'value'){
                return $is_booked ? 1 : 0;
            }
            elseif($is_booked){
                return [];
            }
            return [
                "id"              => $trip->id,
                "bus_id"          => $trip->bus_id,
                "plate_number"    => $bus?->plate_number,
                "available_seats" => [
                    'seat_id'     => $seat_id,
                    "code"        => 'Seat-' . sprintf("%02d", $seat_id)
                ]
            ];
        }

        // loop trips bus seats and match booked seats
        $response = [];
        foreach ($trips as $trip) {
            $bus  =  $trip->bus;
            $seats  =  $bus->seats()
            ->when($seat_id , function($seat) use($seat_id) {
                $seat->where('id' , $seat_id);
            })
            ->pluck('id')->toArray();
            $available_seats = [];
            foreach ($seats as $seat_id) {
                if(!$bookings->where('trip_id' , $trip->id)->where('seat_id' , $seat_id)->count()){
                    $available_seats[] = [
                        'seat_id' => $seat_id,
                        "code"    => 'Seat-' . sprintf("%02d", $seat_id)
                    ];
                }
            }

            // if there's no seats available so trips complete so dont return trip
            if(count($available_seats)){
                $response[]           = [
                    "id"              => $trip->id,
                    "bus_id"          => $trip->bus_id,
                    "plate_number"    => $bus?->plate_number,
                    "available_seats" => $available_seats,
                ];
            }
        }
        return $response;
    }
}


