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
                    <h5 class="breadcrumbs-title">Update Redeem point</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('redeem-point.index')}}">Redeem Points</a>
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
            {{ Form::open(['url' => route('redeem-point.update',$redeemPoint->id),'method' => 'PUT', 'class' => 'row']) }}
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="start" type="number" max="99999" min="0" name="start"  value="{{ $redeemPoint->start }}" required>
                    <label for="start">Start</label>
                    @if ($errors->has('start'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('start') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="end" type="number" max="99999" min="0" name="end" value="{{ $redeemPoint->end }}" required>
                    <label for="end">End</label>
                    @if ($errors->has('end'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('end') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s12">
                    <input id="discount" type="number" max="99999" min="0" name="discount" value="{{ $redeemPoint->discount }}" required>
                    <label for="discount">Discount</label>
                    @if ($errors->has('discount'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('discount') }}</strong>
                    </span>
                    @endif
                </div>
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
