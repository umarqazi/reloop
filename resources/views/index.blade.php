@extends('layouts.dashboard')
@section('content')
    <body>
    @php
    $authUser = \Illuminate\Support\Facades\Auth::user();
    @endphp
    <div class="row m-0 cards-row">
        @if($authUser->hasRole('admin'))
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
        @endif
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
                <h5>{{ $totalAwardedPoints }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Awarded ReLoop Points</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>{{ $totalRedeemedPoints }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Redeemed ReLoop Points</p>
                </div>
            </div>
        </div>
    </div>
    @if($authUser->hasRole('admin'))
        <div class="row m-0 cards-row">
            <div class="input-field col s3">
                {{ Form::select('user_id[]', (['' => 'Select User', 'all' => 'All Users'] + $allUsers), null, ['id' => 'user_id','required' => 'required', 'class' => 'users-dropdown']) }}
                <label>Household Users</label>
                @if ($errors->has('user_id'))
                    <span class="help-block">
                            <strong class="red-text">{{ $errors->first('user_id') }}</strong>
                        </span>
                @endif
            </div>
            <div class="input-field col s3">
                {{ Form::select('organization_id[]', (['' => 'Select Organization', 'all' => 'All Organizations'] + $allOrganizations), null, ['id' => 'organization_id','required' => 'required', 'class' => 'users-dropdown']) }}
                <label>Organizations</label>
                @if ($errors->has('organization_id'))
                    <span class="help-block">
                            <strong class="red-text">{{ $errors->first('organization_id') }}</strong>
                        </span>
                @endif
            </div>
            <div class="input-field col s3">
                {{ Form::select('driver_id[]', (['' => 'Select Driver', 'all' => 'All Drivers'] + $allDrivers), null, ['id' => 'driver_id','required' => 'required', 'class' => 'users-dropdown']) }}
                <label>Drivers</label>
                @if ($errors->has('driver_id'))
                    <span class="help-block">
                            <strong class="red-text">{{ $errors->first('driver_id') }}</strong>
                        </span>
                @endif
            </div>
            <div class="input-field col s3">
                {{ Form::select('supervisor_id[]', (['' => 'Select Supervisor', 'all' => 'All Supervisors'] + $allSupervisors), null, ['id' => 'supervisor_id','required' => 'required', 'class' => 'users-dropdown']) }}
                <label>Supervisors</label>
                @if ($errors->has('supervisor_id'))
                    <span class="help-block">
                            <strong class="red-text">{{ $errors->first('supervisor_id') }}</strong>
                        </span>
                @endif
            </div>
        </div>
    @endif
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
                @if($authUser->hasRole('admin'))
                    <h5>{{ ($dashboard->total_co2_emission_reduced) ?? 0 }} Kg</h5>
                @else
                    <h5>{{ ($dashboard->co2_emission_reduced) ?? 0 }} Kg</h5>
                @endif
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>CO<sub>2</sub> Emission Reduced</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                @if($authUser->hasRole('admin'))
                    <h5>{{ ($dashboard->total_trees_saved) ?? 0 }} trees</h5>
                @else
                    <h5>{{ ($dashboard->trees_saved) ?? 0 }} trees</h5>
                @endif
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Trees Saved</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                @if($authUser->hasRole('admin'))
                    <h5>{{ ($dashboard->total_oil_saved) ?? 0 }} ltrs</h5>
                @else
                    <h5>{{ ($dashboard->oil_saved) ?? 0 }} ltrs</h5>
                @endif
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Oil Saved</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                @if($authUser->hasRole('admin'))
                    <h5>{{ ($dashboard->total_electricity_saved) ?? 0 }} Kwh</h5>
                @else
                    <h5>{{ ($dashboard->electricity_saved) ?? 0 }} Kwh</h5>
                @endif
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Electricity Saved</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                @if($authUser->hasRole('admin'))
                    <h5>{{ ($dashboard->total_water_saved) ?? 0 }} ltrs</h5>
                @else
                    <h5>{{ ($dashboard->water_saved) ?? 0 }} ltrs</h5>
                @endif
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Water Saved</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                @if($authUser->hasRole('admin'))
                    <h5>{{ ($dashboard->total_landfill_space_saved) ?? 0 }} ft<sup>3</sup></h5>
                @else
                    <h5>{{ ($dashboard->landfill_space_saved) ?? 0 }} ft<sup>3</sup></h5>
                @endif
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Landfill Space Saved</p>
                </div>
            </div>
        </div>
    </div>

    </body>

@endsection
