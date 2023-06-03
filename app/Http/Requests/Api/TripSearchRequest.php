<?php

namespace App\Http\Requests\Api;

use App\Models\TripStation;
use Illuminate\Foundation\Http\FormRequest;

class TripSearchRequest extends FormRequest
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
            'date'                      => 'required|date|after_or_equal:'.date('Y-m-d'),
            'source_station_id'         => 'required|integer|different:destination_station_id|exists:stations,id',
            'destination_station_id'    => 'required|integer|exists:stations,id',
            // 'right_order'               => 'in:1'
        ];
    }

    protected function prepareForValidation()
    {
        $TripStation       = TripStation::where('trip_id'     , $this->trip_id )->get();
        $source_order      = $TripStation->where('station_id' , $this->source_station_id )->first()?->order;
        $destination_order = $TripStation->where('station_id' , $this->destination_station_id )->first()?->order;
        $this->merge([
            'source_order'      => $source_order,
            'destination_order' => $destination_order,
            // 'right_order'       => $destination_order && $source_order && $destination_order > $source_order ? 1 : 0,
        ]);
    }

    public function messages()
    {
        return [
            "right_order.in" => "Please Choose Source Station and Destination according to trip line sequence",
        ];
    }
}
