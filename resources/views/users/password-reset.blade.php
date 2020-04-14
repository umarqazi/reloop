@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">Password Reset Form</h5>
                    <ol class="breadcrumbs">
                        <li>
                            <a href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="active">
                            <a href="{{ route('password-requests.index') }}">Password Reset Requests</a>
                        </li>
                        <li class="active">Password Reset Form</li>
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
                {{ Form::open(['url' => route('password-requests.update', $request->id), 'method' => 'PUT', 'class' => 'row']) }}
                <div class="col s12">
                    <div class="input-field col s12">
                        <input id="email" name="email" type="text" value="{{ $request->email }}" readonly >
                        <label for="first_name">Email</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field col s12">
                        <input id="password" name="password" type="text" required >
                        <label for="password">Password</label>
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col s12">
                    <div class="input-field col s12">
                        <input id="confirm_password" name="confirm_password" type="text" required >
                        <label for="confirm_password">Confirm Password</label>
                    </div>
                    @if ($errors->has('confirm_password'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('confirm_password') }}</strong>
                    </span>
                    @endif
                </div>
                    <div class="col s12">
                        <div class="input-field col s12">
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </div>
                    </div>
                {{ Form::close() }}
        </div>
    </div>
@endsection
