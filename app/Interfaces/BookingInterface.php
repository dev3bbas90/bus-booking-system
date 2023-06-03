<?php
namespace App\Interfaces;

use App\Interfaces\BaseInterface;
use Illuminate\Http\Request;

interface BookingInterface extends BaseInterface{
    /**
     * Book Seat
     * @param Request $request
     * @return Collection
    */
    public function book(Request $request);
}
