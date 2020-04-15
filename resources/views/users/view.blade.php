@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">View Driver's Location</h5>
                    <ol class="breadcrumbs">
                        <li>
                            <a href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="active">
                            <a href="{{ route('driver.index') }}">Drivers</a>
                        </li>
                        <li class="active">Driver's Location</li>
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

                    <div class="col s12">
                        <div class="input-field col s12">
                            <input id="location" type="text" name="location" value="{{ $driver->addresses->first()->location }}" required>
                            <label for="address" >Location</label>
                        </div>
                    </div>
                    <div class="col s12">
                    <div class="input-field col s12">
                        <input id="updated_at" type="text" name="updated_at" value="{{ $driver->addresses->first()->updated_at }}" required>
                        <label for="address" >Updated At</label>
                    </div>
                   </div>
                    <div class="col s12">
                        <div class="input-field col s12">
                            <button type="submit" class="btn btn-primary"><a href="http://www.google.com/maps/place/{{ $driver->addresses->first()->latitude }},{{ $driver->addresses->first()->longitude }}" target="_blank" style="color: white">View Map</a></button>
                        </div>
                    </div>

        </div>
    </div>
@endsection
