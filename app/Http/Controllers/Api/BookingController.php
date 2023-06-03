<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Interfaces\BookingInterface;

class BookingController extends ApiBaseController
{
    protected $interface;
    public function __construct(BookingInterface $interface)
    {
        $this->middleware('jwt.verify');
        // interface instance
        $this->interface = $interface;
    }

    /**
     * @OA\Get(
     *     path="/api/bookings",
     *     description="retrieve authed user bookings",
     *     tags={"Bookings"},
     *     security={{ "jwt": {} }} ,
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\Property(property="message"   , type="string" ,  example="success" ),
     *    @OA\Property(property="data"      , type="object" ,  ref="#/components/schemas/Booking" )
     * ),
     * @OA\Response(
     *    response=400,
     *    description="If any error happened",
     *    @OA\JsonContent(
     *       @OA\Property(property="message" , type="string" , example="error"),
     *       @OA\Property(property="errors"  , type="string" , example="Not Authenticated" ),
     *    )
     * )
     * )
    */
    public function index()
    {
        $bookings   =   BookingResource::collection( $this->interface->all(where:[['user_id' , auth('api')->id()]]) );
        return $this->success($bookings , 'My Bookings');
    }

    /**
     * @OA\Get(
     *     path="/api/bookings/{id}",
     *     description="retrieve authed user selected booking ",
     *     tags={"Bookings"},
     *     security={{ "jwt": {} }} ,
     * @OA\Parameter(
     *    description="id of booking",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\Property(property="message"   , type="string" ,  example="success" ),
     *    @OA\Property(property="data"      , type="object" ,  ref="#/components/schemas/Booking" )
     * ),
     * @OA\Response(
     *    response=400,
     *    description="If any error happened",
     *    @OA\JsonContent(
     *       @OA\Property(property="message" , type="string" , example="error"),
     *       @OA\Property(property="errors"  , type="string" , example="Not Authenticated" ),
     *    )
     * )
     * )
    */
    public function show($id)
    {
        $booking = $this->interface->find($id);
        if(!$booking){
            return $this->error(null , 'Not Found !!' , 404);
        }
        $booking = new BookingResource( $this->interface->find($id) );
        return $this->success($booking , 'Booking Details');
    }

    /**
     * @OA\Post(
     * path="/api/bookings/book",
     * description="book seat",
     * tags={"Bookings"},
     * security={{ "jwt": {} }} ,
     * @OA\RequestBody(
     *    required=true,
     *    description="booking paramters (trip_id ,seat_id ,  source_station_id , destination_station_id  )",
     *    @OA\JsonContent(
     *       required={ "trip_id" , "seat_id"   , "source" , "destination"},
     *       @OA\Property(property="trip_id"    , type="interger", format="text", example="1"),
     *       @OA\Property(property="seat_id"    , type="interger", format="text", example="1"),
     *       @OA\Property(property="source_station_id"     , type="interger", format="text", example="1"),
     *       @OA\Property(property="destination_station_id", type="interger", format="text", example="3"),
     *    ),
     *),
     * @OA\Response(
     *     response=200,
     *     description="Booking stored successfully",
     *     @OA\JsonContent(
     *         description="Success",
     *     )
     * ),
     * @OA\Response(
     *     response=403,
     *     description="Unauthenticated",
     *      @OA\JsonContent(
     *         @OA\Property(property="message", type="string", format="text", example="You Are Not Authorized!"),
     *       )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="Validation Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Fill Data")
     *    )
     *  )
     * )
    */
    public function book(BookingRequest $request)
    {
        $booking = $this->interface->book($request);
        if($booking){
            $booking = new BookingResource($booking);
            return $this->success( $booking , 'booking Stored Successfully');
        }
        return $this->error( null , 'Seat Not Found');
    }

}
