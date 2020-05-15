@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
        </div>
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">Create Organization</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('organization.index')}}">Organizations</a>
                        </li>
                        <li class="active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

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

    <div class="container">
        <div class="section">
            <br>
            {{ Form::open(['url' => route('organization.store'),
                           'class' => 'row', 'id'=> 'appended-filed-wrap']) }}

            <div class="col s12">
                <div class="input-field col s6">
                    <input id="name" type="text" name="name" required>
                    <label for="name">Name</label>
                    @if ($errors->has('name'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="email" type="email" name="email" required>
                    <label for="email">Email</label>
                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="phone_number" type="text" name="phone_number" required>
                    <label for="phone_number">Mobile Number</label>
                    @if ($errors->has('phone_number'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('phone_number') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="password" type="password" name="password" required>
                    <label for="password">Password</label>
                    @if ($errors->has('password'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    {{ Form::select('no_of_employees', (['' => 'Select No of Employees'] + $noOfEmployees), null, ['id' => 'no_of_employees']) }}
                    <label for="no_of_employees">Number of employees</label>
                    @if ($errors->has('no_of_employees'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('no_of_employees') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    {{ Form::select('no_of_branches', (['' => 'Select No of Branches'] + $noOfBranches), null, ['id' => 'no_of_branches']) }}
                    <label for="no_of_branches">Number of branches</label>
                    @if ($errors->has('no_of_branches'))
                        <span class="help-block">
                                <strong class="red-text">{{ $errors->first('no_of_branches') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s12">
                    {{ Form::select('sector_id', (['' => 'Choose Organization Sector'] + $sectors), null, ['id' => 'sector_id','required' => 'required']) }}
                    <label>Sector</label>
                </div>
            </div>
            <div id="input_fields_wrap" class="col s12">
                <div class="adrs-title">
                    <h5>Address</h5>
                    <button class="btn btn-primary add-more-filed">Add More</button>
                </div>
                <div class="appendable-filed">
                    <div class="input-field col s3">
                        <select name="type[]" id="type1" required>
                            <option value="" disabled selected>Choose Type</option>
                            <option value="office">Office</option>
                            <option value="warehouse">Warehouse</option>
                            <option value="shop">Shop</option>
                        </select>
                        <label>Property Type</label>
                        @if ($errors->has('type'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('type') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-field col s3">
                        {{ Form::select('city_id[]', (['' => 'Choose City'] + $cities), null, ['id' => 'user_city_id','required' => 'required']) }}
                        <label>City</label>
                        @if ($errors->has('city_id'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('city_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-field col s3">
                        {{ Form::select('district_id[]', (['' => 'Choose District']), null, ['id' => 'user_district_id','required' => 'required']) }}
                        <label>District</label>
                        @if ($errors->has('district_id'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('district_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-field col s3">
                        <input id="street[]" type="text" name="street[]" required>
                        <label for="street[]">Street/Cluster</label>
                        @if ($errors->has('street'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('street') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-field col s3">
                        <input id="floor[]" type="text" name="floor[]" required>
                        <label for="floor[]">Floor No.</label>
                        @if ($errors->has('floor'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('floor') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-field col s3">
                        <input id="unit-number[]" type="text" name="unit-number[]" required>
                        <label for="unit-number[]">Unit No.</label>
                        @if ($errors->has('unit-number'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('unit-number') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-field col s3">
                        <input id="location[]" type="text" name="location[]" required>
                        <label for="location[]">Location</label>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-field col s3">
                        <input id="occupants[]" type="number" name="occupants[]" required>
                        <label for="occupants[]">No. of Occupants</label>
                        @if ($errors->has('occupants'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('occupants') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col s12">
                <div class="input-field col s12">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>

            {{ Form::close() }}
        </div>
    </div>
@endsection
