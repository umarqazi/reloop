
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
                    <h5 class="breadcrumbs-title">Update Coupon</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('coupon.index')}}">Coupons</a>
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
            {{ Form::open(['url' => route('coupon.update',$coupon->id),'method' => 'PUT', 'class' => 'row']) }}
            <div class="col s12 coupon-wrapper">
                <div class="input-field col s4">
                    <select name="apply_for_user" id="apply_for_user" required>
                        <option value="" disabled selected>Choose Coupon For</option>
                        <option value='1' {{ $coupon->apply_for_user == '1' ? 'selected': '' }}>Apply on User Type</option>
                        <option value='2' {{ $coupon->apply_for_user == '2' ? 'selected': '' }}>Apply on Specific User</option>
                    </select>
                    <label>Apply on User</label>
                    @if ($errors->has('apply_for_user'))
                        <span class="help-block">
                            <strong class="red-text">{{ $errors->first('apply_for_user') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="input-field col s4">
                    <select name="coupon_user_type" id="coupon_user_type" required>
                        <option value="" disabled selected>Choose Coupon For</option>
                        <option value='1' {{ $coupon->coupon_user_type == '1' ? 'selected': '' }}>Household</option>
                        <option value='2' {{ $coupon->coupon_user_type == '2' ? 'selected': '' }}>Organization</option>
                        <option value='2' {{ $coupon->coupon_user_type == '3' ? 'selected': '' }}>All</option>
                    </select>
                    <label>User Type</label>
                    @if ($errors->has('coupon_user_type'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('coupon_user_type') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s4 list_of_users_wrapper {{ ($coupon->apply_for_user == \App\Services\IApplyForUser::APPLY_ON_USER_TYPE) ? 'hide-wrapper' : '' }}">
                    {{ Form::select('list_user_id', ($users), $specificUser->id ?? null, ['id' => 'list_user_id']) }}
                    <label>Users</label>
                </div>
            </div>
            <div class="col s12 coupon-category-wrapper">
                <div class="input-field col s4">
                    <select name="apply_for_category" id="apply_for_category" required>
                        <option value="" disabled selected>Choose Coupon For Category</option>
                        <option value='1' {{ $coupon->apply_for_category == '1' ? 'selected': '' }}>Apply on Category Type</option>
                        <option value='2' {{ $coupon->apply_for_category == '2' ? 'selected': '' }}>Apply on Specific Category</option>
                    </select>
                    <label>Apply on Category</label>
                    @if ($errors->has('apply_for_category'))
                        <span class="help-block">
                            <strong class="red-text">{{ $errors->first('apply_for_category') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="input-field col s4">
                    <select name="coupon_category_type" id="coupon_category_type" required>
                        <option value="" disabled selected>Choose Coupon For Category</option>
                        <option value='1' {{ $coupon->coupon_category_type == '1' ? 'selected': '' }}>Service</option>
                        <option value='2' {{ $coupon->coupon_category_type == '2' ? 'selected': '' }}>Product</option>
                        <option value='2' {{ $coupon->coupon_category_type == '3' ? 'selected': '' }}>All</option>
                    </select>
                    <label>Category Type</label>
                    @if ($errors->has('coupon_category_type'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('coupon_category_type') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s4 list_of_category_wrapper {{ ($coupon->apply_for_category == \App\Services\IApplyForCategory::APPLY_ON_CATEGORY_TYPE ) ? 'hide-wrapper' : '' }}">
                    {{ Form::select('list_category_id', ($categories), $specificCategory->id ?? null, ['id' => 'list_category_id']) }}
                    <label>Categories</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="code" type="number"  max="99999" min="0" name="code" value="{{ $coupon->code }}" required>
                    <label for="start">Code</label>
                    @if ($errors->has('code'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('code') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <select name="type" id="type" required>
                        <option value="" disabled selected>Choose Coupon Type</option>
                        <option value="1" {{ $coupon->type==1 ? 'selected': '' }} >Fixed</option>
                        <option value="2" {{ $coupon->type==2 ? 'selected': '' }} >Percentage</option>
                    </select>
                    <label for="type">Type</label>
                    @if ($errors->has('type'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('type') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="max_usage_per_user" value="{{ $coupon->max_usage_per_user }}" type="number" max="99999" min="1" name="max_usage_per_user" required>
                    <label>Max Usage Per User</label>
                    @if ($errors->has('max_usage_per_user'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('max_usage_per_user') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="amount" type="number" max="99999" min="0" name="amount" value="{{ $coupon->amount }}" required>
                    <label for="amount">Amount</label>
                    @if ($errors->has('amount'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('amount') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="max_usage_limit" type="number" max="99999" min="1" name="max_usage_limit" value="{{ $coupon->max_usage_limit }}" required>
                    <label>Max Usage Limit</label>
                    @if ($errors->has('max_usage_limit'))
                        <span class="help-block">
                <strong class="red-text">{{ $errors->first('max_usage_limit') }}</strong>
            </span>
                    @endif
                </div>
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
