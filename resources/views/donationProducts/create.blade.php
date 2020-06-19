@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
        </div>
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">Create Donation Product</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('donation-categories.index')}}">Donation Categories</a>
                        </li>
                        <li><a href="{{route('donation-categories.edit', $category->id)}}">{{ $category->name }}</a>
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
            <br>
            {{ Form::open(['url' => route('donation-products.store'), 'class' => 'row']) }}
                {{ Form::hidden('category_id', $category->id) }}

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
                    <input id="price" type="number" max="99999" min="0" name="redeem_points" required>
                    <label for="price">Redeem Points</label>
                    @if ($errors->has('redeem_points'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('redeem_points') }}</strong>
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
                {{--<div class="input-field col s6">
                    {{ Form::select('category_id', (['' => 'Choose Donation Product Category'] + $categories), null, ['id' => 'category_id']) }}
                    <label>Donation Product Category</label>
                    @if ($errors->has('category_id'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('category_id') }}</strong>
                    </span>
                    @endif
                </div>--}}
                <div class="input-field col s6">
                    <select name="status" id="status" required>
                        <option value="" disabled selected>Choose Donation Product Status</option>
                        <option value="0">Inactive</option>
                        <option value="1">Active</option>
                    </select>
                    <label>Donation Product Status</label>
                    @if ($errors->has('status'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('status') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <select name="product_for" id="product_for" required>
                        <option value="" disabled selected>Product For</option>
                        <option value={{\App\Services\IProductFor::HOUSE_HOLD}} >House Hold</option>
                        <option value={{\App\Services\IProductFor::ORGANIZATION}} >Organization</option>
                        <option value={{\App\Services\IProductFor::BOTH}} >Both</option>
                    </select>
                    <label>Product For</label>
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
