<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripStationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'station_id'    => $this->station_id,
            'station_name'  => $this->station?->name,
            'order'         => $this->order,
            'arrive_time'   => $this->arrive_time,
            'take_off_time' => $this->take_off_time,
        ];
    }
}
