<?php
namespace App\Interfaces;

use Illuminate\Http\Request;

interface TripInterface extends BaseInterface{
    /**
     * get all models
     * @param array $columns
     * @param array $relations
     * @return Collection
    */
    public function all(array $columns=['*'],array $relations=[],array $where=[] , array $filter=[]) ;

    /**
     * get Available Seats
     * @param Request $request
     * @return Collection
    */
    public function available_seats(Request $request) ;
}
