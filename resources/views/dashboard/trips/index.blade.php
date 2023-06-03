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
                    <a href="{{ route('dashboard.trips.create') }}" class="btn btn-success  float-right px-3 py-3 my-2" >
                        <i class="nav-icon fas fa-plane-departure"></i>
                        Add New
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive hoverable-table">
                    <table id="categories-table" class="table courses-table" style="width: 100% !important;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Bus</th>
                            <th>Souorce</th>
                            <th>Destination</th>
                            <th>take_off_time</th>
                            <th>arrive_time</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($trips as $trip)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $trip->bus->plate_number }}</td>

                                <td>{{ $trip->source?->name }}</td>
                                <td>{{ $trip->destination?->name }}</td>
                                <td>{{ $trip->take_off_time }}</td>
                                <td>{{ $trip->arrive_time }}</td>
                                <td> actoins </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
