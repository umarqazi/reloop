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
                    <h5 class="breadcrumbs-title">Create {{ ($type == 1) ? 'User' : (($type == 3) ? 'Driver' : (($type == 4) ? 'Supervisor' : '')) }}</h5>
                    <ol class="breadcrumbs">
                        <li>
                            <a href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="active">
                            <a href="{{ route($route.'.index') }}">{{ ($type == 1) ? 'User' : (($type == 3) ? 'Driver' : (($type == 4) ? 'Supervisor' : '')) }}</a>
                        </li>
                        <li class="active">Create</li>
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
            {{ Form::open(['url' => route($route.'.store'), 'class' => 'row','enctype' => 'multipart/form-data']) }}
            {{ Form::hidden('user_type', $type) }}
                <div class="col s12">
                    <div class="input-field col s6">
                        <input id="first_name" name="first_name" type="text" required >
                        <label for="first_name">First Name</label>
                        @if ($errors->has('first_name'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-field col s6">
                        <input id="last_name" name="last_name" type="text"required >
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
                        <input id="phone_number" name="phone_number" type="number" required >
                        <label for="phone_number" data-error="wrong" data-success="right">Phone Number</label>
                        @if ($errors->has('phone_number'))
                            <span class="help-block">
                            <strong class="red-text">{{ $errors->first('phone_number') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="input-field col s6">
                        <input id="birth_date" name="birth_date" placeholder="Date of Birth" type="date" required >
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
                        <input id="email" name="email" type="email" required>
                        <label for="email" >Email</label>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-field col s6">
                        <input id="password" name="password" type="password" required >
                        <label for="password">Password</label>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field col s12">
                        <input id="location" type="text" name="location" required>
                        <label for="location">Location</label>
                        @if ($errors->has('location'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('location') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field col s6">
                        {{ Form::select('city_id', (['' => 'Choose City'] + $cities), null, ['id' => 'city_id','required' => 'required']) }}
                        <label>City</label>
                    </div>
                    <div class="input-field col s6">
                        {{ Form::select('district_id', (['' => 'Choose District'] + $districts), null, ['id' => 'district_id','required' => 'required']) }}
                        <label>District</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field col s6">
                        <select  id="status" name="status">
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select>
                        <label for="status" >Status</label>
                    </div>
                    <div class="input-field col s6">
                        <select  id="reports" name="reports" required>
                            <option value="0">Enable</option>
                            <option value="1">Disable</option>
                        </select>
                        <label for="status" >Reports</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field col s6">
                        <h6 class="custom-label">Avatar</h6>
                        <input type="file" class="form-control-file" name="avatar" id="avatar">
                    </div>
                </div>
                @if($type == 1)
                <div id="input_fields_wrap" class="col s12">
                    <div class="adrs-title">
                        <h5>Address</h5>
                    </div>
                        <div class="input-field col s3">
                            <select name="type"  id="type1" required>
                                <option value="" disabled selected>Choose Type</option>
                                <option value="1">Villa</option>
                                <option value="2">Apartment</option>
                            </select>
                            <label>Type</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="bedrooms" type="number" name="bedrooms" required>
                            <label for="bedrooms">No of Bedrooms</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="occupants" type="number" name="occupants" required>
                            <label for="occupants">No of Occupants</label>
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
                            <label for="street">Street</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="floor" type="text" name="floor" required>
                            <label for="floor">Floor</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="unit-number" type="text" name="unit-number" required>
                            <label for="unit-number">Unit Number</label>
                        </div>
                </div>
                @endif

                <div class="col s12">
                    <div class="input-field col s12">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
