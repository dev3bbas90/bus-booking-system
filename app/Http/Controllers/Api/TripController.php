<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\TripSearchRequest;
use App\Http\Resources\TripResource;
use App\Interfaces\TripInterface;
use Illuminate\Http\Request;

class TripController extends ApiBaseController
{
    protected $interface;
    public function __construct(TripInterface $interface)
    {
        $this->middleware('jwt.verify');
        // interface instance
        $this->interface = $interface;
    }

    /**
     * @OA\Get(
     *     path="/api/trips",
     *     description="retrieve Filtered Trips",
     *     tags={"Trips"},
     *     security={{ "jwt": {} }} ,
     * @OA\Parameter(
     *    description="trip date ",
     *    in="query",
     *    name="date",
     *    example="2023-06-02",
     *    required=true,
     * ),
     * @OA\Parameter(
     *    description="source",
     *    in="query",
     *    name="source",
     *    example=1,
     *    required=true,
     * ),
     * @OA\Parameter(
     *    description="destination",
     *    in="query",
     *    name="destination",
     *    example=3,
     *    required=true,
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\Property(property="message"   , type="string" ,  example="Trips" ),
     *    @OA\Property(property="data"      , type="object" ,  ref="#/components/schemas/Trip" )
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
    public function index(TripSearchRequest $request)
    {
        $trips = $this->interface->all(filter:$request->all());
        $trips = TripResource::collection( $trips );
        return $this->success($trips , 'Trips');
    }

    /**
     * @OA\Get(
     *     path="/api/trips/{trip_id}",
     *     description="show trip details with available seats",
     *     tags={"Trips"},
     *     security={{ "jwt": {} }} ,
     * @OA\Parameter(
     *    description="trip id ",
     *    in="path",
     *    name="trip_id",
     *    example="1",
     *    required=true,
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\Property(property="message"   , type="string" ,  example="Trips" ),
     *    @OA\Property(property="data"      , type="object" ,  ref="#/components/schemas/Trip" )
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
    public function show($trip_id)
    {
        $trip = $this->interface->find($trip_id);
        if(!$trip ){
            return $this->error('Not Found !!' , 'error' , 404);
        }
        $trip = new TripResource( $trip );
        return $this->success($trip , 'Trip Details');
    }


    /**
     * @OA\Post(
     * path="/api/trips/available-seats",
     * description="get Available Seats",
     * tags={"Trips"},
     * security={{ "jwt": {} }} ,
     * @OA\RequestBody(
     *    required=true,
     *    description="trip search paramters (source , destination , date )",
     *    @OA\JsonContent(
     *       required={"source","destination","date"},
     *       @OA\Property(property="trip_id"                , type="interger", format="text", example="1"),
     *       @OA\Property(property="source_station_id"      , type="interger", format="text", example="1"),
     *       @OA\Property(property="destination_station_id" , type="interger", format="text", example="3"),
     *       @OA\Property(property="date"                   , type="string"  , format="date", example="2023-06-02")
     *    ),
     *),
     * @OA\Response(
     *     response=200,
     *     description="Available Seats",
     *     @OA\JsonContent(
     *         description="Success",
     *         @OA\Property(property="message"   , type="string" ,  example="Available Seats" ),
     *         @OA\Property(property="data"      , type="object" , description ="Array of Trips and available seats inside" )
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
    public function available_seats(TripSearchRequest $request)
    {
        $available_seats = $this->interface->available_seats($request);
        return $this->success($available_seats , 'Trip Available Seats');
    }

}
