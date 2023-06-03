@extends('layouts.app')

@section('content')
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="card-title">
                    <h4>Buses</h4>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('dashboard.stations.create') }}" class="btn btn-success  float-right px-3 py-3 my-2" >
                        <i class="nav-icon fas fa-plus"></i>
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
                            <th>plate Number</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($buses as $bus)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bus->plate_number }}</td>
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
