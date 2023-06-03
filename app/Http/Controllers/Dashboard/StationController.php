<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\StationInterface;
use Exception;
use Illuminate\Http\Request;

class StationController extends Controller
{

    protected $interface;
    public function __construct(StationInterface $interface)
    {
        $this->middleware('auth:dashboard');
        // interface instance
        $this->interface = $interface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stations = $this->interface->all();
        return view("dashboard.stations.index" , compact('stations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.stations.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $data = $this->interface->store($request->all());
            if(!$data){
                toastr()->error('Ann Error Occured');
                return redirect()->back();
            }
            toastr()->success('Trip Saved successfully');
            return redirect()->route('dashboard.stations.index');
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
