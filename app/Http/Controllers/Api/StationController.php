<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\ApiBaseController;
use App\Http\Resources\StationResource;
use App\Interfaces\StationInterface;
use Illuminate\Http\Request;

class StationController extends ApiBaseController
{
    protected $interface;
    public function __construct(StationInterface $interface)
    {
        $this->middleware('jwt.verify');
        // interface instance
        $this->interface = $interface;
    }
    /**
     * @OA\Get(
     *     path="/api/stations",
     *     description="retrieve authed user profile",
     *     tags={"stations"},
     *     security={{ "jwt": {} }} ,
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\Property(property="message"   , type="string" ,  example="success" ),
     *    @OA\Property(property="data"      , type="object" ,  ref="#/components/schemas/Station" )
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
        $stations   =   StationResource::collection( $this->interface->all() );
        return $this->success($stations , 'stations');
    }
}
