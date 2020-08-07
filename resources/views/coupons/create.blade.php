@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
        </div>
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">Create Coupon</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('coupon.index')}}">Coupons</a>
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
            <br>
            {{ Form::open(['url' => route('coupon.store'),
                           'class' => 'row']) }}

            <div class="col s12 coupon-wrapper">
                <div class="input-field col s4">
                    <select name="apply_for_user" id="apply_for_user" required>
                        <option value="" disabled selected>Choose Coupon For</option>
                        <option value={{ \App\Services\IApplyForUser::APPLY_ON_USER_TYPE }}>Apply on User Type</option>
                        <option value={{ \App\Services\IApplyForUser::APPLY_ON_SPECIFIC_USER }}>Apply on Specific User</option>
                    </select>
                    <label>Apply on User</label>
                    @if ($errors->has('apply_for_user'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('apply_for_user') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s4">
                    {{ Form::select('coupon_user_type', (['' => 'Choose User Type', '1' => 'Household', '2' => 'Organization']), null, ['id' => 'coupon_user_type','required' => 'required']) }}
                    <label>User Type</label>
                    @if ($errors->has('coupon_user_type'))
                        <span class="help-block">
                                <strong class="red-text">{{ $errors->first('coupon_user_type') }}</strong>
                            </span>
                    @endif
                </div>
                <div class="input-field col s4 list_of_users_wrapper">
                    {{ Form::select('list_user_id', (['' => 'Choose User']), null, ['id' => 'list_user_id']) }}
                    <label>Users</label>
                </div>
            </div>
            <div class="col s12 coupon-category-wrapper">
                <div class="input-field col s4">
                    <select name="apply_for_category" id="apply_for_category" required>
                        <option value="" disabled selected>Choose Coupon For</option>
                        <option value={{ \App\Services\IApplyForCategory::APPLY_ON_CATEGORY_TYPE }}>Apply on Category Type</option>
                        <option value={{ \App\Services\IApplyForCategory::APPLY_ON_SPECIFIC_CATEGORY }}>Apply on Specific Category</option>
                    </select>
                    <label>Apply on Category</label>
                    @if ($errors->has('apply_for_category'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('apply_for_category') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s4">
                    {{ Form::select('coupon_category_type', (['' => 'Choose Category Type', '1' => 'Service', '2' => 'Product']), null, ['id' => 'coupon_category_type','required' => 'required']) }}
                    <label>Category Type</label>
                    @if ($errors->has('coupon_category_type'))
                        <span class="help-block">
                                <strong class="red-text">{{ $errors->first('coupon_category_type') }}</strong>
                            </span>
                    @endif
                </div>
                <div class="input-field col s4 list_of_category_wrapper">
                    {{ Form::select('list_category_id', (['' => 'Choose Category']), null, ['id' => 'list_category_id']) }}
                    <label>Categories</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="code" type="text" name="code" required>
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
                        <option value="1">Fixed</option>
                        <option value="2">Percentage</option>
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
                    <input id="max_usage_per_user" type="number" max="99999" min="1" name="max_usage_per_user" required>
                    <label>Max Usage Per User</label>
                    @if ($errors->has('max_usage_per_user'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('max_usage_per_user') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="amount" type="number" max="99999" min="0" name="amount" required>
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
                    <input id="max_usage_limit" type="number" max="99999" min="1" name="max_usage_limit" required>
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
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
