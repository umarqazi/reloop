@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">View Organization's Location</h5>
                    <ol class="breadcrumbs">
                        <li>
                            <a href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="active">
                            <a href="{{ route('organization.index') }}">Organizations</a>
                        </li>
                        <li class="active">Organization's Location</li>
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

            @if($organization->addresses->first()->latitude)
                <div class="col s12">
                    <div class="input-field col s12">
                        <a href="http://www.google.com/maps/place/{{ $organization->addresses->first()->latitude }},{{ $organization->addresses->first()->longitude }}"
                           target="_blank" style="color: white">
                            <button type="submit" class="btn btn-primary">View on Map</button>
                        </a>
                    </div>
                </div>
            @else
                <div class="col s12">
                    <div class="input-field col s12">
                        <label for="address">No location found for this organization.</label>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
