@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
        </div>
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">Create Product</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('product.index')}}">Products</a>
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
            {{ Form::open(['url' => route('product.store'),
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
                    {{ Form::select('product_category', (['' => 'Choose Product Category'] + $categories), null, ['id' => 'product_category']) }}
                    <label>Product Category</label>
                    @if ($errors->has('product_category'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('product_category') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <select name="product_status" required>
                        <option value="" disabled selected>Choose Product Status</option>
                        <option value="0">In Active</option>
                        <option value="1">Active</option>
                    </select>
                    <label>Product Status</label>
                    @if ($errors->has('product_status'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('product_status') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s12">
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
