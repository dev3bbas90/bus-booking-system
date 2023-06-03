<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreTripRequest;
use App\Interfaces\BusInterface;
use App\Interfaces\StationInterface;
use App\Interfaces\TripInterface;
use Exception;
use Illuminate\Http\Request;

class TripController extends Controller
{
    protected $interface , $stationInterface ,$busInterface;
    public function __construct(TripInterface $interface , StationInterface $stationInterface , BusInterface $busInterface)
    {
        $this->middleware('auth:dashboard');
        // interface instance
        $this->interface        = $interface;
        $this->stationInterface = $stationInterface;
        $this->busInterface     = $busInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips = $this->interface->all();
        return view('dashboard.trips.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stations = $this->stationInterface->all();
        $buses    = $this->busInterface->all();
        return view('dashboard.trips.create', compact('stations','buses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTripRequest $request)
    {
        try{
            $data = $this->interface->store($request->all());
            if(!$data){
                toastr()->error('Ann Error Occured');
                return redirect()->back();
            }
            toastr()->success('Trip Saved successfully');
            return redirect()->route('dashboard.trips.index');
        }catch(Exception $ex){
            toastr()->error('Ann Error Occured');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
