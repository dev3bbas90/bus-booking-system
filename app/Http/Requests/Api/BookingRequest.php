<?php

namespace App\Http\Requests\Api;

use App\Models\Trip;
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
            'source_station_id'      => 'required|integer|different:end_station_id|exists:stations,id|exists:trip_lines,station_id,trip_id,'.$this->trip_id,
            'destination_station_id' => 'required|integer|exists:stations,id|exists:trip_lines,station_id,trip_id,'.$this->trip_id,
            'seat_id'                => ['required', 'integer',
                Rule::exists('seats', 'id')
                    ->where('bus_id', Trip::findOrFail($this->trip_id)->bus_id)
            ]
        ];
    }
}
