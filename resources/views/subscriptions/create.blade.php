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
                    <h5 class="breadcrumbs-title">Create Subscription</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('subscription.index')}}">Subscriptions</a>
                        </li>
                        <li class="active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="section">
            <br>
            {{ Form::open(['url' => route('subscription.store'),
                           'class' => 'row',
                           'enctype' => 'multipart/form-data']) }}

            <div class="col s12">
                <div class="input-field col s6">
                    <input id="name" type="text" name="name" required>
                    <label for="name">Name</label>
                    @if ($errors->has('name'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="price" type="number" max="99999" min="0" name="price" required>
                    <label for="price">Price</label>
                    @if ($errors->has('price'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('price') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s12">
                    <textarea id="description" class="materialize-textarea" name="description" required></textarea>
                    <label for="description">Description</label>
                    @if ($errors->has('description'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('description') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    {{ Form::select('subscription_category', (['' => 'Choose Subscription Category'] + $categories), null, ['id' => 'subscription_category']) }}
                    <label>Subscription Category</label>
                    @if ($errors->has('subscription_category'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('subscription_category') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <select name="subscription_status" required>
                        <option value="" disabled selected>Choose Subscription Status</option>
                        <option value="0">In Active</option>
                        <option value="1">Active</option>
                    </select>
                    <label>Subscription Status</label>
                    @if ($errors->has('subscription_status'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('subscription_status') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="request_allowed" type="number" name="request_allowed" required>
                    <label for="request_allowed">Request(s) Allowed</label>
                    @if ($errors->has('request_allowed'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input type="file" class="form-control-file" name="avatar" id="avatar">
                    @if ($errors->has('avatar'))
                        <br><span class="help-block">
                        <strong class="red-text">{{ $errors->first('avatar') }}</strong>
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
