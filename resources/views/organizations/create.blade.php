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
                    <input id="email" type="email"  name="email" required>
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
                    <input id="phone_number" type="number" name="phone_number" required>
                    <label for="phone_number">Phone Number</label>
                    @if ($errors->has('phone_number'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('phone_number') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="password" type="password"  name="password" required>
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
                    <input id="no_of_employees" type="number" name="no_of_employees" required>
                    <label for="no_of_employees">Number of employees</label>
                    @if ($errors->has('no_of_employees'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('no_of_employees') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="no_of_branches" type="number"  name="no_of_branches" required>
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
                <div class="input-field col s12">
                      {{ Form::select('sector_id', (['' => 'Choose Organization Sector'] + $sectors), null, ['id' => 'sector_id']) }}
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
                        <select name="type[]"  id="type1" required>
                            <option value="" disabled selected>Choose Type</option>
                            <option value="1">Villa</option>
                            <option value="2">Apartment</option>
                        </select>
                        <label>Type</label>
                    </div>
                    <div class="input-field col s3">
                        <input id="bedrooms[]" type="number" name="bedrooms[]" required>
                        <label for="bedrooms">No of Bedrooms</label>
                    </div>
                    <div class="input-field col s3">
                        <input id="occupants[]" type="number" name="occupants[]" required>
                        <label for="occupants">No of Occupants</label>
                    </div>
                    <div class="input-field col s3">
                        {{ Form::select('city_id[]', (['' => 'Choose City'] + $cities), null, ['id' => 'city_id']) }}
                        <label>City</label>
                    </div>
                    <div class="input-field col s3">
                        <select name="district[]"  id="district1" required>
                            <option value="" disabled selected>Choose District</option>
                            <option value="Qasur">Qasur</option>
                            <option value="Okarda">Okarda</option>
                        </select>
                        <label>District</label>
                    </div>
                    <div class="input-field col s3">
                        <input id="street[]" type="text" name="street[]" required>
                        <label for="street[]">Street</label>
                    </div>
                    <div class="input-field col s3">
                        <input id="floor[]" type="text" name="floor[]" required>
                        <label for="floor[]">Floor</label>
                    </div>
                    <div class="input-field col s3">
                        <input id="unit-number[]" type="text" name="unit-number[]" required>
                        <label for="unit-number[]">Unit Number</label>
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
