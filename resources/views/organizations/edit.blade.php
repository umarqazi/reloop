@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <!-- Search for small screen -->
        <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
        </div>
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">Update Organization</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('organization.index')}}">Organizations</a>
                        </li>
                        <li class="active">Update</li>
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
            {{ Form::open(['url' => route('organization.update',$organization->id),'method' => 'PUT', 'class' => 'row']) }}
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="name" type="text" name="name" value="{{$organization->name}}" required>
                    <label for="name">Name</label>
                    @if ($errors->has('name'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="email" type="email"  name="email"   value="{{$organization->users[0]->email}}" readonly required>
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
                    <input id="phone_number" type="number" name="phone_number"  value="{{$organization->users[0]->phone_number}}" readonly required>
                    <label for="phone_number">Phone Number</label>
                    @if ($errors->has('phone_number'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('phone_number') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="no_of_employees" type="number" name="no_of_employees" value="{{$organization->no_of_employees}}" required>
                    <label for="no_of_employees">Number of employees</label>
                    @if ($errors->has('no_of_employees'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('no_of_employees') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="no_of_branches" type="number"  name="no_of_branches"  value="{{$organization->no_of_branches}}" required>
                    <label for="no_of_branches">Number of branches</label>
                    @if ($errors->has('no_of_branches'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('no_of_branches') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <select name="status" id="status" required>
                        <option value="" disabled selected>Choose Product Status</option>
                        <option value="0" {{ $organization->users[0]->status==false ? 'selected': '' }}>Unapproved</option>
                        <option value="1" {{ $organization->users[0]->status==true ? 'selected': '' }}>approved</option>
                    </select>
                    <label>Organization Status</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s12">
                    {{ Form::select('sector_id', (['' => 'Choose Organization Sector'] + $sectors), $organization->sector->id, ['id' => 'sector_id']) }}
                    <label>Sector</label>
                </div>
            </div>

            <div id="input_fields_wrap" class="col s12">

            @foreach($organization->users[0]->addresses as $key => $address)

                    @if($key == 0)
                    <div class="adrs-title">
                        <h5>Address</h5>
                        <button class="btn btn-primary add-more-filed">Add More</button>
                    </div>
                    @endif
                    <div class="appendable-filed">
                        <a href="javascript:void(0);" class="remove-append"><i class="fa fa-minus" aria-hidden="true"></i></a>
                        <div class="input-field col s3">
                            <input type="hidden" name="address-id[]" value="{{ $address->id }}">
                            <select name="type[]"  id="type1" required>
                                <option value="" disabled selected>Choose Type</option>
                                <option value="1" {{ $address->type=='1' ? 'selected': '' }}>Villa</option>
                                <option value="2" {{ $address->type=='2' ? 'selected': '' }}>Apartment</option>
                            </select>
                            <label>Type</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="bedrooms[]" type="number" name="bedrooms[]" value="{{ $address->no_of_bedrooms }}" required>
                            <label for="bedrooms[]"">No of Bedrooms</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="occupants[]" type="number" name="occupants[]" value="{{ $address->no_of_occupants }}"  required>
                            <label for="occupants[]">No of Occupants</label>
                        </div>
                        <div class="input-field col s3">
                            {{ Form::select('city_id[]', (['' => 'Choose City'] + $cities), $address->city_id , ['id' => 'city_id']) }}
                            <label>City</label>
                        </div>
                        <div class="input-field col s3">
                            <select name="district[]"  id="district1" required>
                                <option value="" disabled selected>Choose District</option>
                                <option value="Qasur" {{ $address->district=='Qasur' ? 'selected': '' }} >Qasur</option>
                                <option value="Okarda" {{ $address->district=='Okarda' ? 'selected': '' }}>Okarda</option>
                            </select>
                            <label>District</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="street[]" type="text" name="street[]" value="{{ $address->street }}" required>
                            <label for="street[]">Street</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="floor[]" type="text" name="floor[]" value="{{ $address->floor }}" required>
                            <label for="floor[]">Floor</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="unit-number[]" type="text" name="unit-number[]" value="{{ $address->unit_number }}" required>
                            <label for="unit-number[]">Unit Number</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="location[]" type="text" name="location[]" value="{{ $address->location }}" required>
                            <label for="location[]">Location</label>
                        </div>
                    </div>
            @endforeach
            </div>


            <div class="col s12">
                <div class="input-field col s12">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
