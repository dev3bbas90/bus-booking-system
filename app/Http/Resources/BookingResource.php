<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          =>  $this->id,
            'trip'        =>  new TripResource($this->trip),
            'user'        =>  new UserResource($this->user),
            'bus'         =>  new BusResource($this->trip?->bus),
            'seat'        =>  new SeatResource($this->seat),
            'source'      =>  new TripStationsResource($this->source_station),
            'destination' =>  new TripStationsResource($this->destination_station),
        ];
    }
}
