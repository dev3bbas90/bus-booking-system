@extends('layouts.app')

@section('content')
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="card-title">
                    <h4>Stations</h4>
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
                   <form class="form" method="POST" action="{{ route('dashboard.stations.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row card-body">
                            <div class="form-group col-md-12">
                                <label> Name </label>
                                <div class="input-group">
                                    <input type="text" name="name"  value="{{ @old('name') }}" class="form-control @error('name') is-invalid @enderror" required placeholder="Enter Name" />
                                </div>
                                @error('name')
                                    <small class="form-text text-danger">{{$message}}</small>
                                @enderror
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
