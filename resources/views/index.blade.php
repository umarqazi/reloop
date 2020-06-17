@extends('layouts.dashboard')
@section('content')
    <body>
    <div class="row m-0 cards-row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>{{ $organizations }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Total Organizations</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>{{ $users }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Household Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>{{ count($activeUsers) }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Live Active Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>{{ $materialCategories }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Material Categories</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>{{ $products }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Total Products</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>{{ $orders }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Total Product Orders</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>{{ $collectionRequest }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Total Collection Orders</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>{{ $totalRecycledKg }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Total Recycled (kg)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>0</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Awarded ReLoop Points</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>0</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Redeemed ReLoop Points</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-0 cards-row">
        <div class="input-field col s3">
            {{ Form::select('user_id[]', (['' => 'Select User'] + $allUsers), null, ['id' => 'user_id','required' => 'required']) }}
            <label>Household Users</label>
            @if ($errors->has('user_id'))
                <span class="help-block">
                        <strong class="red-text">{{ $errors->first('user_id') }}</strong>
                    </span>
            @endif
        </div>
        <div class="input-field col s3">
            {{ Form::select('organization_id[]', (['' => 'Select Organization'] + $allOrganizations), null, ['id' => 'organization_id','required' => 'required']) }}
            <label>Organizations</label>
            @if ($errors->has('organization_id'))
                <span class="help-block">
                        <strong class="red-text">{{ $errors->first('organization_id') }}</strong>
                    </span>
            @endif
        </div>
        <div class="input-field col s3">
            {{ Form::select('driver_id[]', (['' => 'Select Driver'] + $allDrivers), null, ['id' => 'driver_id','required' => 'required']) }}
            <label>Drivers</label>
            @if ($errors->has('driver_id'))
                <span class="help-block">
                        <strong class="red-text">{{ $errors->first('driver_id') }}</strong>
                    </span>
            @endif
        </div>
        <div class="input-field col s3">
            {{ Form::select('supervisor_id[]', (['' => 'Select Supervisor'] + $allSupervisors), null, ['id' => 'supervisor_id','required' => 'required']) }}
            <label>Supervisors</label>
            @if ($errors->has('supervisor_id'))
                <span class="help-block">
                        <strong class="red-text">{{ $errors->first('supervisor_id') }}</strong>
                    </span>
            @endif
        </div>
    </div>
    <div id="chart"></div>
    <div class="row  mx-0 my-2 charts-top-row">

        {{--Bar Chart--}}
        @include('charts.bar')

        {{--Pie Chart--}}
        @include('charts.pie')
    </div>
    <div class="row m-0 cards-row">
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>@if(!empty($dashboard->total_co2_emission_reduced)){{$dashboard->total_co2_emission_reduced}} @else 0 @endif Kg</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>CO<sub>2</sub> Emission Reduced</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>@if(!empty($dashboard->total_trees_saved)){{$dashboard->total_trees_saved}} @else 0 @endif trees</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Trees Saved</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>@if(!empty($dashboard->total_oil_saved)){{$dashboard->total_oil_saved}} @else 0 @endif ltrs</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Oil Saved</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>@if(!empty($dashboard->total_electricity_saved)){{$dashboard->total_electricity_saved}} @else 0 @endif Kwh</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Electricity Saved</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>@if(!empty($dashboard->total_water_saved)){{$dashboard->total_water_saved}} @else 0 @endif ltrs</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Water Saved</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>@if(!empty($dashboard->total_landfill_space_saved)){{$dashboard->total_landfill_space_saved}} @else 0 @endif ft<sup>3</sup></h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Landfill Space Saved</p>
                </div>
            </div>
        </div>
    </div>

    </body>

@endsection
