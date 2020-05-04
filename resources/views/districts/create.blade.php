@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
        </div>
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">Create Related District</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('getCities')}}">Cities</a>
                        </li>
                        <li><a href="{{route('cities.edit', $city->id)}}">{{ $city->name }}</a>
                        </li>
                        <li class="active">Create Related District</li>
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
            {{ Form::open(['url' => route('districts.store'),
                           'class' => 'row']) }}

            <input id="city_id" type="text" name="city_id" value="{{$city->id}}" hidden>
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
                    <select name="status" id="status" required>
                        <option value="" disabled selected>Choose District Status</option>
                        <option value="0">Inactive</option>
                        <option value="1">Active</option>
                    </select>
                    <label>Product Status</label>
                    @if ($errors->has('status'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('status') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s12">
                    <select multiple name="order_acceptance_days[]" required>
                        <option value="" disabled selected>Choose Days</option>
                        @foreach($days as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                    <label for=order_acceptance_days">Order Acceptance Days</label>
                    @if ($errors->has('order_acceptance_days'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('order_acceptance_days') }}</strong>
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
