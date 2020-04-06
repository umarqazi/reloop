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
                    <h5 class="breadcrumbs-title">Create Material Category</h5>
                    <ol class="breadcrumbs">
                        <li>
                            <a href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="active">
                            <a href="{{ route('material-category.index') }}">Material Category</a>
                        </li>
                        <li class="active">Create</li>
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
            {{ Form::open(['url' => route('material-category.store'), 'class' => 'row', 'files' => true]) }}
                <div class="col s12">
                    <div class="input-field col s6">
                        <input id="name" name="name" type="text" class="validate">
                        <label for="name">Name</label>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-field col s6">
                        <select class="validate" id="status" name="status">
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select>
                        <label for="status" data-error="wrong" data-success="right">Status</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field col s12">
                        <textarea class="validate materialize-textarea" id="description" name="description"></textarea>
                        <label for="description" data-error="wrong" data-success="right">Description</label>
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field col s12">
                        <h6 class="custom-label">Avatar</h6>
                        <input id="avatar" name="avatar" type="file" class="attach-file">
                    </div>
                </div>
                <div id="input_fields_wrap" class="col s12 mt-5">
                    <div class="adrs-title col s12">
                        <h5>Reward Points</h5>
                    </div>
                    <div class="input-field col s4">
                        <input id="quantity" name="quantity" type="number" class="validate" value="1" readonly >
                        <label for="quantity">Quantity</label>
                        @if ($errors->has('quantity'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('quantity') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-field col s4">
                        {{ Form::select('unit', (['' => 'Choose Unit'] + $units), null, ['id' => 'unit']) }}
                        <label for="unit">Product Unit</label>
                        @if ($errors->has('unit'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('unit') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-field col s4">
                        <input id="reward_points" name="reward_points" type="number" class="validate">
                        <label for="reward-points">Reward Points</label>
                        @if ($errors->has('reward_points'))
                            <span class="help-block">
                                <strong class="red-text">{{ $errors->first('reward_points') }}</strong>
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
