<?php
namespace App\Repositories;

use App\Http\Traits\SeatsAvailability;
use App\Interfaces\BookingInterface;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingRepository extends BaseRepository implements BookingInterface
{
    use SeatsAvailability;
    protected $model;
    public function __construct(Booking $model)
    {
        $this->model =$model;
    }

    public function book(Request $request)
    {
        try {
            $seat = $this->SeatsAvailability($request);
            // if seat not booked in this period
            if($seat && $seat?->booked == 0){
                $booking = $this->model->create([
                    'user_id'              => auth('api')->id(),
                    'trip_id'              => $request->trip_id,
                    'seat_id'              => $request->seat_id,
                    'source_order'         => $request->source_order,
                    'destination_order'    => $request->destination_order,
                ]);
                return $booking->fresh();
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

}
