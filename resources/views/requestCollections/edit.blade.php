@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">Update Weight</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('collection-requests.index')}}">Collection Requests</a>
                        </li>
                        <li><a href="{{route('collection-requests.show' , $requestCollection->request_id)}}">Request Details</a>
                        </li>
                        <li class="active">Update Weight</li>
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
            {{ Form::open(['url' => route('request-collections.update',$requestCollection->id),'method' => 'PUT', 'class' => 'row']) }}
            <div class="col s12">
                <div class="input-field col s12">
                    <input id="weight" type="number" name="weight" value="{{ $requestCollection->weight }}" required>
                    <label for="weight">Weight</label>
                    @if ($errors->has('weight'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('weight') }}</strong>
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
