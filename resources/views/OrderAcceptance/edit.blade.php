@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">Update Order Acceptance Time</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('order-acceptances.index')}}">Order Acceptances</a>
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
            {{ Form::open(['url' => route('order-acceptances.update',$orderAcceptance->id),'method' => 'PUT', 'class' => 'row']) }}
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="to" type="text" name="to" value="{{$orderAcceptance->to}}" required>
                    <label for="to">To(From)</label>
                    @if ($errors->has('to'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('to') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="from" type="text" name="from" value="{{$orderAcceptance->from}}"required>
                    <label for="from">From(Day)</label>
                    @if ($errors->has('from'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('from') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    {{ Form::select('district_id', (['' => 'Choose District'] + $districts), $orderAcceptance->district_id, ['id' => 'district_id','required' => 'required']) }}
                    <label>District</label>
                    @if ($errors->has('district_id'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('district_id') }}</strong>
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
