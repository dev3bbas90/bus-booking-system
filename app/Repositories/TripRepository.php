<?php
namespace App\Repositories;

use App\Http\Traits\SeatsAvailability;
use App\Interfaces\TripInterface;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripRepository extends BaseRepository implements TripInterface
{
    use SeatsAvailability;
    protected $model;
    public function __construct(Trip $model)
    {
        $this->model =$model;
    }

    public function all(array $columns=['*'],array $relations=[],array $where=[] , $filter=[])
    {
        $data =  $this->model->filter($filter)->where($where)->with($relations);
        return $data -> get($columns);
    }

    public function available_seats(Request $request)
    {
        $trips = $this->SeatsAvailabilityV2($request , 'object');
        return $trips;
    }

    public function handleTripSeats($trips)
    {
        $response =  [];
        foreach ($trips as $seats) {
            $trip_row   = $seats->first();

            $seats_ids  = $seats->pluck('seat_id')->toArray();
            $collection = collect($seats_ids);
            $seats_ids  = $collection->map(function ($seat_id, $key) {
                return [
                    "id"   => $seat_id,
                    "code" => 'Seat-' . sprintf("%02d", $seat_id)
                ];
            });
            $response[] = [
                'id'             => $trip_row?->id,
                'bus_id'         => $trip_row?->bus_id,
                'plate_number'   => $trip_row?->plate_number,
                'available_seat' => $seats_ids
            ];
        }
        return $response;
    }

}
