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
                    <h5 class="breadcrumbs-title">Update Product</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('product.index')}}">Products</a>
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
            {{ Form::open(['url' => route('product.update',$product->id),'method' => 'PUT', 'class' => 'row','enctype' => 'multipart/form-data']) }}
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="name" type="text" name="name" value="{{ $product->name }}" required>
                    <label for="name">Name</label>
                    @if ($errors->has('name'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="price" type="number" max="99999" min="0" name="price" value="{{ $product->price }}" required>
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
                    <textarea id="description" class="materialize-textarea" name="description" required>{{ $product->description }}</textarea>
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
                    <select name="category_id" id="category_id" required>
                        <option value="" disabled selected>Choose Product Category</option>
                        <option value="3" {{ $product->category_id==3 ? 'selected': '' }}>Recycling Boxes</option>
                        <option value="4" {{ $product->category_id==4 ? 'selected': '' }}>Environmental Products</option>
                    </select>
                    <label>Product Category</label>
                    @if ($errors->has('category_id'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('category_id') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <select name="status" id="status" required>
                        <option value="" disabled selected>Choose Product Status</option>
                        <option value="0" {{ $product->status==0 ? 'selected': '' }}>Inactive</option>
                        <option value="1" {{ $product->status==1 ? 'selected': '' }}>Active</option>
                    </select>
                    <label>Product Status</label>
                    @if ($errors->has('status'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('status') }}</strong>
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
