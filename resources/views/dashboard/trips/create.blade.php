@extends('layouts.app')

@section('content')
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="card-title">
                    <h4>Trips</h4>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('dashboard.stations.index') }}" class="btn btn-success  float-right px-3 py-3 my-2" >
                        <i class="nav-icon fas fa-plane-departure"></i>
                        All
                    </a>
                </div>
            </div>

            <div class="card-body">

                   <!--begin::Form-->
                   <form class="form" method="POST" action="{{ route('dashboard.trips.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row card-body">

                            <div class="form-group col-md-6">
                                <label> Bus </label>
                                <div class="input-group">
                                    <select class="form-control select2" id="kt_select2_1" name="bus_id">
                                        <option value="">Bus</option>
                                        @foreach ($buses as $bus)
                                            <option value="{{$bus->id}}">{{$bus->plate_number}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('bus_id')
                                    <small class="form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6"></div>

                            <div class="form-group col-md-6">
                                <label> Source </label>
                                <div class="input-group">
                                    <select class="form-control select2" id="kt_select2_1" name="source_station_id">
                                        <option value="">Select</option>
                                        @foreach ($stations as $station)
                                            <option value="{{$station->id}}">{{$station->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('source_station_id')
                                    <small class="form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label> Destinatoin </label>
                                <div class="input-group">
                                    <select class="form-control select2" id="kt_select2_1" name="destination_station_id">
                                        <option value="">Select</option>
                                        @foreach ($stations as $station)
                                            <option value="{{$station->id}}">{{$station->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('destination_station_id')
                                    <small class="form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label> Take Off Time </label>
                                <div class="input-group">
                                    <input type="text" name="take_off_time" id="take_off_time" class="form-control daterangepicker">
                                </div>
                                @error('take_off_time')
                                    <small class="form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label> Take Off Time </label>
                                <div class="input-group">
                                    <input type="text" name="take_off_time" id="take_off_time" class="form-control daterangepicker">
                                </div>
                                @error('take_off_time')
                                    <small class="form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card card-custom gutter-b example example-compact">
                                    <div class="card-header text-center">
                                        <div class="card-title">
                                            <span class="card-icon">
                                            </span>
                                            <h3 class="card-label">
                                                <span class="font-weight-bolder  mb-4 text-hover-state-dark">
                                                    <h5>Trip Stations</h5>
                                                </span>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div id="repeater" class="w-100">
                                                <div class="form-group">
                                                    <div data-repeater-list="Stations" class="col-md-12">
                                                        <div data-repeater-item="Station"
                                                            class="form-group row align-items-center">
                                                            <div class="row col-md-11">

                                                                <div class="form-group col-md-4 col-sm-6">
                                                                    <label>Station</label>
                                                                    <div class="input-group">
                                                                        <select class="form-control select2" id="kt_select2_1" name="source_station_id">
                                                                            <option value="">Select</option>
                                                                            @foreach ($stations as $station)
                                                                                <option value="{{$station->id}}">{{$station->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    @error('source_station_id')
                                                                        <small class="form-text text-danger">{{$message}}</small>
                                                                    @enderror
                                                                </div>

                                                            </div>
                                                            <div class="col-md-1">
                                                                <svg data-repeater-delete="" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="color-gold font-5 cursor-pointer add" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M7 11h10v2H7z"></path><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path></svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <svg stroke="currentColor" data-repeater-create="" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" class="color-gold font-5 cursor-pointer add" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path></svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">
                                Save
                            </button>
                        </div>
                    </form>
                    <!--end::Form-->

            </div>
        </div>
    </div>

</div>

@endsection
