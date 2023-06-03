<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreTripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'bus_id'                 => 'required|integer|exists:buses,id',
            'source_station_id'      => 'required|integer|different:destination_station_id|exists:stations,id|exists:trip_stations,station_id,trip_id,'.$this->trip_id,
            'destination_station_id' => 'required|integer|exists:stations,id',
            'take_off_time'          => 'required|integer|date',
            'arrive_time'            => 'required|integer|date',
            'stations'               => 'required|array',
            'stations.*.id'          => 'integer|exists:stations,id',
        ];
    }
}
