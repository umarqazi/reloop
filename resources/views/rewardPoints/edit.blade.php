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
                    <h5 class="breadcrumbs-title">Update Reward point</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('reward-point.index')}}">Reward Points</a>
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
            {{ Form::open(['url' => route('reward-point.update',$rewardPoint->id),'method' => 'PUT', 'class' => 'row']) }}
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="min_kg" type="number" max="99999" min="0" name="min_kg"  value="{{ $rewardPoint->min_kg }}" required>
                    <label for="min_kg">Min (Kg)</label>
                    @if ($errors->has('min_kg'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('min_kg') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="max_kg" type="number" max="99999" min="0" name="max_kg" value="{{ $rewardPoint->max_kg }}" required>
                    <label for="max_kg">Max (Kg)</label>
                    @if ($errors->has('max_kg'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('max_kg') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s12">
                    <input id="points" type="number" max="99999" min="0" name="points" value="{{ $rewardPoint->points }}" required>
                    <label for="points">Points</label>
                    @if ($errors->has('points'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('points') }}</strong>
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
