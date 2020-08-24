@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <!-- Search for small screen -->
        <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
        </div>
        @php
            $route = '';
            if($type){
                $route = ($type == 1) ? 'user' : (($type == 3) ? 'driver' : (($type == 4) ? 'supervisor' : ''));
            }
        @endphp
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">Edit {{ ($type == 1) ? 'User' : (($type == 3) ? 'Driver' : (($type == 4) ? 'Supervisor' : '')) }}</h5>
                    <ol class="breadcrumbs">
                        <li>
                            <a href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="active">
                            <a href="{{ route($route.'.index') }}">{{ ($type == 1) ? 'Users' : (($type == 3) ? 'Drivers' : (($type == 4) ? 'Supervisors' : '')) }}</a>
                        </li>
                        <li class="active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="section">
            @if ($message = Session::get('success'))
                <div id="card-alert" class="card green">
                    <div class="card-content white-text">
                        <p>{{ $message }}</p>
                    </div>
                    <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div id="card-alert" class="card red">
                    <div class="card-content white-text">
                        <p>{{ $message }}</p>
                    </div>
                    <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            @if(!empty($user))
                @php
                    $type = $user->user_type;
                    $route = ($type == 1) ? 'user' : (($type == 3) ? 'driver' : (($type == 4) ? 'supervisor' : ''));
                @endphp
                {{ Form::open(['url' => route($route.'.update', $user->id), 'method' => 'PUT', 'class' => 'row', 'id' => 'user_edit_form', 'enctype' => 'multipart/form-data']) }}
                {{ Form::hidden('user_type', $type) }}
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input id="first_name" name="first_name" type="text" value="{{ $user->first_name }}" required >
                            <label for="first_name">First Name</label>
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong class="red-text">{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s6">
                            <input id="last_name" name="last_name" type="text" value="{{ $user->last_name }}" required >
                            <label for="last_name">Last Name</label>
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong class="red-text">{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input id="phone_number" name="phone_number" type="text" value="{{ $user->phone_number }}" required >
                            <label for="phone_number" >Mobile Number</label>
                            @if ($errors->has('phone_number'))
                                <span class="help-block">
                                <strong class="red-text">{{ $errors->first('phone_number') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="input-field col s6">
                            <label class="date-label">{{ ($type == 1) ? 'Date of Birth' : 'Date of Joining' }}</label>
                            <input id="birth_date" name="birth_date" placeholder="Date of Birth" type="date" value="{{ $user->birth_date }}" required >
                            {{--<label for="birth_date">Date of Birth</label>--}}
                            @if ($errors->has('birth_date'))
                                <span class="help-block">
                                    <strong class="red-text">{{ $errors->first('birth_date') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input  id="email" name="email" type="email"  value="{{ $user->email }}" required >
                            <label for="email" >Email</label>
                        </div>
                        <div class="input-field col s6">
                            <select  id="status" name="status">
                                <option value="0" @if($user->status == 0) selected @endif>Inactive</option>
                                <option value="1" @if($user->status == 1) selected @endif>Active</option>
                            </select>
                            <label for="status" >Status</label>
                        </div>
                    </div>
                    @if($type == 1 || $type == 2)
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input  id="total_trips" type="text" name="total_trips" value="{{ count($totalTrips) }}" readonly>
                            <label for="total_trips" >Total Trips</label>
                        </div>
                        <div class="input-field col s6">
                            <input  id="total_recycled" type="text" name="total_recycled" value="{{ $totalWeight }}" readonly>
                            <label for="total_recycled" >Total Recycled (kgs)</label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input  id="total_product_orders" type="text" name="total_product_orders" value="{{ count($totalOrders) }}" readonly>
                            <label for="total_product_orders" >Total Product Orders</label>
                        </div>
                        <div class="input-field col s6">
                            <input  id="total_reward_points" type="text" name="total_reward_points" value="{{ $rewardPoints }}" readonly>
                            <label for="total_reward_points" >Total Points</label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input  id="remaining_points" type="text" name="remaining_points" value="{{ ($user->reward_points) ?? 0 }}" readonly>
                            <label for="remaining_points" >Remaining Points</label>
                        </div>
                        <div class="input-field col s6">
                            <input  id="total_bills" type="text" name="total_bills" value="{{ $totalBills }}" readonly>
                            <label for="total_bills" >Total Bills</label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input  id="organization_name" type="text" name="organization_name" value="{{ ($user->organization) ? $user->organization->name : '-' }}" readonly>
                            <label for="organization_name" >Organization Name</label>
                        </div>
                        <div class="input-field col s6">
                            <input  id="organization_code" type="text" name="organization_code" value="{{ ($user->organization) ? $user->organization->org_external_id : '-' }}" readonly>
                            <label for="organization_code" >Organization Code</label>
                        </div>
                    </div>
                    @endif
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input  id="organization_name" type="text" name="organization_name" value="{{ ($environmentalStats->trees_saved) ?? 0 }}" readonly>
                            <label for="organization_name" >Total Trees Saved</label>
                        </div>
                        <div class="input-field col s6">
                            <input  id="organization_code" type="text" name="organization_code" value="{{ ($environmentalStats->co2_emission_reduced) ?? 0 }}" readonly>
                            <label for="organization_code" >Total CO<sub>2</sub> Reduced</label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input  id="organization_name" type="text" name="organization_name" value="{{ ($environmentalStats->oil_saved) ?? 0 }}" readonly>
                            <label for="organization_name" >Total Oil Saved</label>
                        </div>
                        <div class="input-field col s6">
                            <input  id="organization_code" type="text" name="organization_code" value="{{ ($environmentalStats->water_saved) ?? 0 }}" readonly>
                            <label for="organization_code" >Total Water Saved</label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input  id="organization_name" type="text" name="organization_name" value="{{ ($environmentalStats->landfill_space_saved) ?? 0 }}" readonly>
                            <label for="organization_name" >Total Landfill Space Saved</label>
                        </div>
                        <div class="input-field col s6">
                            <input  id="organization_code" type="text" name="organization_code" value="{{ ($environmentalStats->electricity_saved) ?? 0 }}" readonly>
                            <label for="organization_code" >Total Electricity Saved</label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s12">
                            @if($user->addresses->first())
                                <input  id="organization_name" type="text" name="organization_name"
                                        value="{{ $user->addresses->first()->unit_number .', '. $user->addresses->first()->building_name .', '.
                                                $user->addresses->first()->street .', '. $user->addresses->first()->district->name .', '. $user->addresses->first()->city->name }}" readonly>
                                <label for="organization_name" >Address</label>
                            @endif
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s12">
                            @if($user->addresses->first())
                            <input id="location" type="text" name="location" value="{{ $user->addresses->first()->location }}" required>
                            <label for="address" >Location</label>
                            @else
                                <input id="location" type="text" name="location"  required>
                                <label for="address" >Location</label>
                            @endif
                                @if ($errors->has('location'))
                                <span class="help-block">
                                    <strong class="red-text">{{ $errors->first('location') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    @if($type != 1)
                    <div class="col s12 city-wrapper">
                        <div class="input-field col s6">
                            {{ Form::select('city_id', (['' => 'Choose City'] + $cities), $user->addresses->first()->city_id, ['id' => 'user_city_id','required' => 'required']) }}
                            <label>City</label>
                        </div>
                        <div class="input-field col s6">
                            {{ Form::select('district_id[]', ($districts), $district_ids, ['multiple','id' => 'user_district_id','required' => 'required']) }}
                            <label>District</label>
                        </div>
                    </div>
                    @endif
                    <div class="col s12">
                        <div class="input-field col s6">
                            <select  id="reports" name="reports" required>
                                <option value="0" {{ ($user->reports == \App\Services\IUserReports::DISABLE) ?  'selected' : ''}} >Disable</option>
                                <option value="1"  {{ ($user->reports == \App\Services\IUserReports::ENABLE) ?  'selected' : ''}} >Enable</option>
                            </select>
                            <label for="reports" >Reports</label>
                        </div>
                        <div class="input-field col s6">
                            <select  id="gender" name="gender">
                                <option value="male" @if($user->gender == 'male') selected @endif>Male</option>
                                <option value="female" @if($user->gender == 'female') selected @endif>Female</option>
                            </select>
                            <label for="gender" >Gender</label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="col s6 box-image">
                            <img src="{{ $user->avatar }}">
                        </div>
                        <div class="input-field col s6 ">
                            <h6 class="custom-label">Update Photo</h6>
                            <input type="file" class="form-control-file" name="avatar" id="avatar">
                        </div>
                    </div>
                    @if($type == 1 && $user->addresses->first())
                        <div id="input_fields_wrap" class="col s12">
                            <div class="adrs-title">
                                <h5>Address</h5>
                            </div>
                            <div class="input-field col s3">
                                <input type="hidden" name="address-id" value="{{ $user->addresses[0]->id }}">
                                <select name="type"  id="type1" class="user-property-type" required>
                                    <option value="" disabled selected>Choose Type</option>
                                    <option value="villa" {{ strtolower($user->addresses->first()->type) == 'villa' ? 'selected': '' }}>Villa</option>
                                    <option value="apartment" {{ strtolower($user->addresses->first()->type)=='apartment' ? 'selected': '' }}>Apartment</option>
                                </select>
                                <label>Property Type</label>
                            </div>
                            <div class="input-field col s3">
                                {{ Form::select('city_id', (['' => 'Choose City'] + $cities), $user->addresses->first()->city_id , ['id' => 'city_id']) }}
                                <label>City</label>
                            </div>
                            <div class="input-field col s3">
                                {{ Form::select('district_id', (['' => 'Choose District'] + $districts), $user->addresses->first()->district_id , ['id' => 'district_id']) }}
                                <label>District</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="street" type="text" name="street" value="{{ $user->addresses->first()->street }}" required>
                                <label for="street">Street/Cluster</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="building_name" type="text" name="building_name" value="{{ $user->addresses->first()->building_name }}" required>
                                <label for="building_name">Building Name</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="unit-number" type="text" name="unit-number" value="{{ $user->addresses->first()->unit_number }}" required>
                                <label for="unit-number">Unit No.</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="bedrooms" type="number" name="bedrooms" value="{{ $user->addresses->first()->no_of_bedrooms }}" required>
                                <label for="bedrooms">No. of Bedrooms</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="occupants" type="number" name="occupants" value="{{ $user->addresses->first()->no_of_occupants }}"  required>
                                <label for="occupants">No. of Occupants</label>
                            </div>
                            <div class="input-field col s3 floor-wrapper">
                                @if($user->addresses->first()->type=='apartment')
                                    <input id="floor" type="text" name="floor" value="{{ $user->addresses->first()->floor }}" required>
                                    <label for="floor">Floor No.</label>
                                    <input type="hidden" class="floor-no" value="{{ $user->addresses->first()->floor }}">
                                @else
                                    <input type="hidden" class="floor-no" value="{{ $user->addresses->first()->floor }}">
                                @endif
                            </div>
                        </div>
                    @endif
                    @if(sizeof($user->addresses) == 0)
                        <div id="input_fields_wrap" class="col s12">
                            <div class="adrs-title">
                                <h5>Address</h5>
                            </div>
                            <div class="input-field col s3">
                                <select name="type"  id="type1" required>
                                    <option value="" disabled selected>Choose Type</option>
                                    <option value="villa">Villa</option>
                                    <option value="apartment">Apartment</option>
                                </select>
                                <label>Property Type</label>
                            </div>
                            <div class="input-field col s3">
                                {{ Form::select('city_id', (['' => 'Choose City'] + $cities), null, ['id' => 'city_id']) }}
                                <label>City</label>
                            </div>
                            <div class="input-field col s3">
                                {{ Form::select('district_id', (['' => 'Choose District'] + $districts), null, ['id' => 'district_id']) }}
                                <label>District</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="street" type="text" name="street" required>
                                <label for="street">Street/Cluster</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="building_name" type="text" name="building_name" required>
                                <label for="building_name">Building Name</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="floor" type="text" name="floor" required>
                                <label for="floor">Floor No.</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="unit-number" type="text" name="unit-number" required>
                                <label for="unit-number">Unit No.</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="bedrooms" type="number" name="bedrooms" required>
                                <label for="bedrooms">No. of Bedrooms</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="occupants" type="number" name="occupants" required>
                                <label for="occupants">No. of Occupants</label>
                            </div>
                        </div>
                    @endif

                    <div class="col s12">
                        <div class="input-field col s12">
                            <button type="submit" class="btn btn-primary update">Update</button>
                        </div>
                    </div>
                {{ Form::close() }}
            @endif
            @if ($message = Session::get('empty'))
                <div id="card-alert" class="card red">
                    <div class="card-content white-text">
                        <p>{{ $message }}</p>
                    </div>
                    <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
@endsection
