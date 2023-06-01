<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ShowAvailableSeatsRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'trip_id'                   => 'required|integer|exists:trips,id',
            'source_station_id'         => 'required|integer|different:end_station_id|exists:stations,id|exists:trip_lines,station_id,trip_id,'.$this->trip_id,
            'destination_station_id'    => 'required|integer|exists:stations,id|exists:trip_lines,station_id,trip_id,'.$this->trip_id,
        ];
    }
}
