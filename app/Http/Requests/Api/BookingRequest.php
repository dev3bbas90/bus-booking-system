<?php

namespace App\Http\Requests\Api;

use App\Models\Trip;
use App\Models\TripStation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trip_id'                => 'required|integer|exists:trips,id',
            'source_station_id'      => 'required|integer|different:destination_station_id|exists:stations,id|exists:trip_stations,station_id,trip_id,'.$this->trip_id,
            'destination_station_id' => 'required|integer|exists:stations,id|exists:trip_stations,station_id,trip_id,'.$this->trip_id,
            'seat_id'                => ['required', 'integer',
                                        Rule::exists('seats', 'id')->where('bus_id', Trip::findOrFail($this->trip_id)?->bus_id)
            ],
            'right_order' => 'in:1'
        ];
    }

    protected function prepareForValidation()
    {
        $TripStation       = TripStation::where('trip_id' , $this->trip_id )->get();
        $source_order      = $TripStation->where('station_id' , $this->source_station_id )->first()?->order;
        $destination_order = $TripStation->where('station_id' , $this->destination_station_id )->first()?->order;

        $this->merge([
            'source_order'      => $source_order,
            'destination_order' => $destination_order,
            'right_order'       => $destination_order > $source_order ? 1 : 0,
        ]);
    }

    public function messages()
    {
        return [
            "right_order.in" => "Please Choose Source Station and Destination according to trip line sequence",
        ];
    }

}
