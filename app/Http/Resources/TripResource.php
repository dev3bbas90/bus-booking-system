<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id'                  => $this->id,
            'bus'                 => new BusResource($this->bus),
            'source'              => new StationResource($this->source),
            'destination'         => new StationResource($this->destination),
            'line_stations'       => TripStationsResource::collection($this->line_stations),
        ];

    }
}
