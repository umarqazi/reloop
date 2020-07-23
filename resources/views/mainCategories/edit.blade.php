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
                    <h5 class="breadcrumbs-title">Edit Main Category</h5>
                    <ol class="breadcrumbs">
                        <li>
                            <a href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="active">
                            <a href="{{ route('main-category.index') }}">Main Category</a>
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
            @if(!empty($mainCategory))
                {{ Form::open(['url' => route('main-category.update', $mainCategory->id), 'method' => 'PUT', 'class' => 'row', 'files' => true]) }}
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input id="name" name="name" type="text" value="{{ $mainCategory->name }}" class="validate">
                            <label for="name">Name</label>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong class="red-text">{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s6">
                            <select class="validate" id="status" name="status">
                                <option value="0" @if($mainCategory->status == 0) selected @endif>Inactive</option>
                                <option value="1" @if($mainCategory->status == 1) selected @endif>Active</option>
                            </select>
                            <label for="status" data-error="wrong" data-success="right">Status</label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s6 main_category_type">
                            <select class="validate" id="type" name="type">
                                <option value="1" @if($mainCategory->type == 1) selected @endif>Subscription</option>
                                <option value="2" @if($mainCategory->type == 2) selected @endif>Product</option>
                            </select>
                            <label for="type" data-error="wrong" data-success="right">Type</label>
                        </div>
                        <div class="input-field col s6 main_category_service_type @if($mainCategory->type == 1) show_service_type @endif">
                            <select class="validate" id="service_type" name="service_type">
                                <option value="">Choose Subscription Type</option>
                                <option value="1"  @if($mainCategory->service_type == 1) selected @endif>Monthly</option>
                                <option value="2"  @if($mainCategory->service_type == 2) selected @endif>One Time</option>
                            </select>
                            <label for="service_type" data-error="wrong" data-success="right">Subscription Type</label>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="input-field col s12">
                            <button type="submit" class="btn btn-primary update">Update</button>
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
