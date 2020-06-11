@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    @if($user->user_type == \App\Services\IUserType::DRIVER)
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
                    @else
                        <h5 class="breadcrumbs-title">View User's Location</h5>
                        <ol class="breadcrumbs">
                            <li>
                                <a href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="active">
                                <a href="{{ route('user.index') }}">Users</a>
                            </li>
                            <li class="active">User's Location</li>
                        </ol>
                    @endif
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

            @if($user->user_type == \App\Services\IUserType::DRIVER)
                @if(!empty($user->currentLocation))
                    <div class="col s12">
                        <div class="input-field col s12">
                            <input id="updated_at" type="text" name="updated_at"
                                   value="{{ $user->currentLocation->updated_at }}" required readonly>
                            <label for="address">Last Updated At</label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s12">
                            <a href="http://www.google.com/maps/place/{{ $user->currentLocation->latitude }},{{ $user->currentLocation->longitude }}"
                               target="_blank" style="color: white">
                                <button type="submit" class="btn btn-primary">View on Map</button>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="col s12">
                        <div class="input-field col s12">
                            <label for="address">No location found for this driver.</label>
                        </div>
                    </div>
                @endif
            @else
                @if($user->addresses->first()->latitude)
                    <div class="col s12">
                        <div class="input-field col s12">
                            <a href="http://www.google.com/maps/place/{{ $user->addresses->first()->latitude }},{{ $user->addresses->first()->longitude }}"
                               target="_blank" style="color: white">
                                <button type="submit" class="btn btn-primary">View on Map</button>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="col s12">
                        <div class="input-field col s12">
                            <label for="address">No location found for this user.</label>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
