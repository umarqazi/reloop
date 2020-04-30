@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
        </div>
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">Create Order Acceptance</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('order-acceptances.index')}}">Order Acceptances</a>
                        </li>
                        <li class="active">Create</li>
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
            {{ Form::open(['url' => route('order-acceptances.store'),
                           'class' => 'row',]) }}

            <div class="col s12">
                <div class="input-field col s6">
                    <input id="from" type="text" name="from" required>
                    <label for="from">From(Day)</label>
                    @if ($errors->has('from'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('from') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="to" type="text" name="to" required>
                    <label for="to">To(Day)</label>
                    @if ($errors->has('to'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('to') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
            <div class="input-field col s6">
                {{ Form::select('district_id', (['' => 'Choose District'] + $districts), null, ['id' => 'district_id','required' => 'required']) }}
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
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
