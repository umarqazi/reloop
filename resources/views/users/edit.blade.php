@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <!-- Search for small screen -->
        <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
        </div>
        @php
            $route = '';
            if($type){
                $route = ($type == 1) ? 'user' : (($type == 3) ? 'driver' : (($type == 4) ? 'supervisor' : ''));
            }
        @endphp
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">Edit {{ ($type == 1) ? 'User' : (($type == 3) ? 'Driver' : (($type == 4) ? 'Supervisor' : '')) }}</h5>
                    <ol class="breadcrumbs">
                        <li>
                            <a href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="active">
                            <a href="{{ route($route.'.index') }}">{{ ($type == 1) ? 'Users' : (($type == 3) ? 'Drivers' : (($type == 4) ? 'Supervisors' : '')) }}</a>
                        </li>
                        <li class="active">Edit</li>
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
            @if(!empty($user))
                @php
                    $type = $user->user_type;
                    $route = ($type == 1) ? 'user' : (($type == 3) ? 'driver' : (($type == 4) ? 'supervisor' : ''));
                @endphp
                {{ Form::open(['url' => route($route.'.update', $user->id), 'method' => 'PUT', 'class' => 'row','enctype' => 'multipart/form-data']) }}
                {{ Form::hidden('user_type', $type) }}
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input id="first_name" name="first_name" type="text" value="{{ $user->first_name }}" class="validate">
                            <label for="first_name">First Name</label>
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong class="red-text">{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s6">
                            <input id="last_name" name="last_name" type="text" value="{{ $user->last_name }}" class="validate">
                            <label for="last_name">Last Name</label>
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong class="red-text">{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input id="phone_number" name="phone_number" type="number" value="{{ $user->phone_number }}" class="validate">
                            <label for="phone_number" data-error="wrong" data-success="right">Phone Number</label>
                            @if ($errors->has('phone_number'))
                                <span class="help-block">
                                <strong class="red-text">{{ $errors->first('phone_number') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="input-field col s6">
                            <input id="birth_date" name="birth_date" placeholder="Date of Birth" type="date" value="{{ $user->birth_date }}" class="validate">
                            {{--<label for="birth_date">Date of Birth</label>--}}
                            @if ($errors->has('birth_date'))
                                <span class="help-block">
                                    <strong class="red-text">{{ $errors->first('birth_date') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input disabled id="email" name="email" type="email" class="validate" value="{{ $user->email }}" readonly>
                            <label for="email" data-error="wrong" data-success="right">Email</label>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong class="red-text">{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s6">
                            <select class="validate" id="status" name="status">
                                <option value="0" @if($user->status == 0) selected @endif>Inactive</option>
                                <option value="1" @if($user->status == 1) selected @endif>Active</option>
                            </select>
                            <label for="status" data-error="wrong" data-success="right">Status</label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s12">
                            <textarea class="validate materialize-textarea" id="address" name="address">{{ $user->address }}</textarea>
                            <label for="address" data-error="wrong" data-success="right">Address</label>
                            @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong class="red-text">{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="col s6 box-image">
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk(env('FILESYSTEM_DRIVER'))->url(config('filesystems.user_avatar_upload_path')).$user->avatar }}">
                        </div>
                        <div class="input-field col s6 ">
                            <input type="file" class="form-control-file" name="avatar" id="avatar">
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s12">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                {{ Form::close() }}
            @endif
            @if ($message = Session::get('empty'))
                <div id="card-alert" class="card red">
                    <div class="card-content white-text">
                        <p>{{ $message }}</p>
                    </div>
                    <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
@endsection
