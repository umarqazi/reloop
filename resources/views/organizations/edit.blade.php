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
            <br>
            {{ Form::open(['url' => route('organization.update',$organization->id),'method' => 'PUT', 'id' => 'org_edit_form', 'class' => 'row']) }}
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
                    <input id="org_external_id" type="text" name="org_external_id" readonly value="{{ $organization->org_external_id }}"  required>
                    <label for="org_external_id">Organization ID</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="email" type="email"  name="email"   value="{{$organization->users->first()->email}}"  required>
                    <label for="email">Email</label>
                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="phone_number" type="text" name="phone_number"  value="{{$organization->users->first()->phone_number}}"  required>
                    <label for="phone_number">Mobile Number</label>
                    @if ($errors->has('phone_number'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('phone_number') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input type="text" value="{{$organization->users->first()->created_at}}"  readonly>
                    <label for="email">Created At</label>
                </div>
                <div class="input-field col s6">
                    <input type="text" value="{{ ($organization->users->first()->verified_at) ?? '-' }}"  readonly>
                    <label for="date_activated">Date Activated</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input type="text" value="{{ $totalWeight }}"  readonly>
                    <label for="email">Total Recycled (Kg)</label>
                </div>
                <div class="input-field col s6">
                    <input type="text" value="{{ ($totalHouseholdsWeight) ?? 0 }}"  readonly>
                    <label for="date_activated">Total Household Recycled (kg)</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input type="text" value="{{ count($totalTrips) }}"  readonly>
                    <label for="email">Total Trips</label>
                </div>
                <div class="input-field col s6">
                    <input type="text" value="{{ count($totalHouseholdsTrips) }}"  readonly>
                    <label for="date_activated">Total Household Trips</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input type="text" value="{{ count($totalOrders) }}"  readonly>
                    <label for="email">Total Product Orders</label>
                </div>
                <div class="input-field col s6">
                    <input type="text" value="{{ $rewardPoints }}"  readonly>
                    <label for="date_activated">Total Points</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input type="text" value="{{ ($organization->users->first()->reward_points) ?? 0 }}"  readonly>
                    <label for="email">Remaining Points</label>
                </div>
                <div class="input-field col s6">
                    <input type="text" value="{{ $totalBills }}"  readonly>
                    <label for="date_activated">Total Bills</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input  type="text" value="{{ ($environmentalStats->trees_saved) ?? 0 }}" readonly>
                    <label for="organization_name" >Total Trees Saved</label>
                </div>
                <div class="input-field col s6">
                    <input  type="text" value="{{ ($environmentalStats->co2_emission_reduced) ?? 0 }}" readonly>
                    <label for="organization_code" >Total CO<sub>2</sub> Reduced</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input  type="text" value="{{ ($environmentalStats->oil_saved) ?? 0 }}" readonly>
                    <label for="organization_name" >Total Oil Saved</label>
                </div>
                <div class="input-field col s6">
                    <input type="text" value="{{ ($environmentalStats->water_saved) ?? 0 }}" readonly>
                    <label for="organization_code" >Total Water Saved</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input  type="text" value="{{ ($environmentalStats->landfill_space_saved) ?? 0 }}" readonly>
                    <label for="organization_name" >Total Landfill Space Saved</label>
                </div>
                <div class="input-field col s6">
                    <input type="text" value="{{ ($environmentalStats->electricity_saved) ?? 0 }}" readonly>
                    <label for="organization_code" >Total Electricity Saved</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input  type="text" value="{{ ($orgUsersEnvironmentalStats->trees_saved) ?? 0 }}" readonly>
                    <label for="organization_name" >Total Household Trees Saved</label>
                </div>
                <div class="input-field col s6">
                    <input  type="text" value="{{ ($orgUsersEnvironmentalStats->co2_emission_reduced) ?? 0 }}" readonly>
                    <label for="organization_code" >Total Household CO<sub>2</sub> Reduced</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input  type="text" value="{{ ($orgUsersEnvironmentalStats->oil_saved) ?? 0 }}" readonly>
                    <label for="organization_name" >Total Household Oil Saved</label>
                </div>
                <div class="input-field col s6">
                    <input type="text" value="{{ ($orgUsersEnvironmentalStats->water_saved) ?? 0 }}" readonly>
                    <label for="organization_code" >Total Household Water Saved</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input  type="text" value="{{ ($orgUsersEnvironmentalStats->landfill_space_saved) ?? 0 }}" readonly>
                    <label for="organization_name" >Total Household Landfill Space Saved</label>
                </div>
                <div class="input-field col s6">
                    <input type="text" value="{{ ($orgUsersEnvironmentalStats->electricity_saved) ?? 0 }}" readonly>
                    <label for="organization_code" >Total Household Electricity Saved</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    {{ Form::select('no_of_employees', (['' => 'Select No of Employees'] + $noOfEmployees), $organization->no_of_employees, ['id' => 'no_of_employees']) }}
                    <label for="no_of_employees">Number of employees</label>
                    @if ($errors->has('no_of_employees'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('no_of_employees') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    {{ Form::select('no_of_branches', (['' => 'Select No of Branches'] + $noOfBranches), $organization->no_of_branches, ['id' => 'no_of_branches']) }}
                    <label for="no_of_branches">Number of branches</label>
                    @if ($errors->has('no_of_branches'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('no_of_branches') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    {{ Form::select('sector_id', (['' => 'Choose Organization Sector'] + $sectors), $organization->sector->id, ['id' => 'sector_id']) }}
                    <label>Sector</label>
                </div>
                <div class="input-field col s6">
                    <select name="status" id="status" required>
                        <option value="" disabled selected>Choose Product Status</option>
                        <option value="0" {{ $organization->users->first()->status== \App\Services\IUserStatus::INACTIVE ? 'selected': '' }}>Inactive</option>
                        <option value="1" {{ $organization->users->first()->status== \App\Services\IUserStatus::ACTIVE ? 'selected': '' }}>Active</option>
                    </select>
                    <label>Status</label>
                </div>
            </div>

            <div id="input_fields_wrap" class="col s12">
                @foreach($organization->users->first()->addresses as $key => $address)
                    @if($key == 0)
                        <div class="adrs-title">
                            <h5>Address</h5>
                            <button class="btn btn-primary add-more-filed">Add More</button>
                        </div>
                    @endif
                    <div class="appendable-filed">
                        @if($key != 0)
                            <a href="javascript:void(0);" class="remove-append"><i class="fa fa-minus" aria-hidden="true"></i></a>
                        @endif
                        <div class="input-field col s3">
                            <input type="hidden" name="address-id[]" value="{{ $address->id }}">
                            <select name="type[]"  id="type1" >
                                <option value="" disabled selected>Choose Type</option>
                                <option value="office" {{ strtolower($address->type) == 'office' ? 'selected': '' }}>Office</option>
                                <option value="warehouse" {{ strtolower($address->type) == 'warehouse' ? 'selected': '' }}>Warehouse</option>
                                <option value="shop" {{ strtolower($address->type) == 'shop' ? 'selected': '' }}>Shop</option>
                            </select>
                            <label>Property Type</label>
                        </div>
                        <div class="input-field col s3">
                            {{ Form::select('city_id[]', (['' => 'Choose City'] + $cities), $address->city_id, ['id' => 'user_city_id','required' => 'required']) }}
                            <label>City</label>
                        </div>
                        <div class="input-field col s3">
                            {{ Form::select('district_id[]', ($districts), $address->district_id, ['id' => 'user_district_id','required' => 'required']) }}
                            <label>District</label>
                            @if ($errors->has('district_id'))
                                <span class="help-block">
                                <strong class="red-text">{{ $errors->first('district_id') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="input-field col s3">
                            <input id="street[]" type="text" name="street[]" value="{{ $address->street }}" required="required">
                            <label for="street[]">Street/Cluster</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="building_name[]" type="text" name="building_name[]" value="{{ $address->building_name }}">
                            <label for="building_name[]">Building Name</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="floor[]" type="text" name="floor[]" value="{{ $address->floor }}" >
                            <label for="floor[]">Floor No.</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="unit-number[]" type="text" name="unit-number[]" value="{{ $address->unit_number }}" >
                            <label for="unit-number[]">Unit No.</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="location[]" type="text" name="location[]" value="{{ $address->location }}" required>
                            <label for="location[]">Location</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="occupants[]" type="number" name="occupants[]" value="{{ $address->no_of_occupants }}" >
                            <label for="occupants[]">No. of Occupants</label>
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="col s12">
                <div class="input-field col s12">
                    <button type="submit" class="btn btn-primary update">Update</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
