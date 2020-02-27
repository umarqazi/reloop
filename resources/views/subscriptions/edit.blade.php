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
                        <li><a href="{{route('subscription.index')}}">Subscription</a>
                        </li>
                        <li class="active">Update</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="section">
            <br>
            {{ Form::open(['url' => route('subscription.update',$subscription->id),'method' => 'PUT', 'class' => 'row','enctype' => 'multipart/form-data']) }}
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="name" type="text" name="name" value="{{ $subscription->name }}" required>
                    <label for="name">Name</label>
                    @if ($errors->has('name'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input id="price" type="number" max="99999" min="0" name="price" value="{{ $subscription->price }}" required>
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
                    <textarea id="description" class="materialize-textarea" name="description" required>{{ $subscription->description }}</textarea>
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
                    <select name="subscription_category" required>
                        <option value="" disabled selected>Choose Subscription Category</option>
                        <option value="1" {{ $subscription->category_id==1 ? 'selected': '' }}>Monthly Subscription</option>
                        <option value="2" {{ $subscription->category_id==2 ? 'selected': '' }}>One Time Service</option>
                    </select>
                    <label>Subscription Category</label>
                </div>
                <div class="input-field col s6">
                    <select name="subscription_status" required>
                        <option value="" disabled selected>Choose Product Status</option>
                        <option value="1" {{ $subscription->status==0 ? 'selected': '' }}>In Active</option>
                        <option value="2" {{ $subscription->status==1 ? 'selected': '' }}>Active</option>
                    </select>
                    <label>Subscription Status</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="request_allowed" type="number" name="request_allowed" value="{{$subscription->request_allowed}}" required>
                    <label for="request_allowed">Request(s) Allowed</label>
                    @if ($errors->has('request_allowed'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6 ">
                    <input type="file" class="form-control-file" name="avatar" id="avatar" value="{{$subscription->avatar}}">
                </div>
                @if ($errors->has('avatar'))
                    <span class="help-block">
                        <strong class="red-text">{{ $errors->first('avatar') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col s12">
                <div class="col s6 box-image">
                    <img src="{{url('storage/images/subscriptions/'.$subscription->avatar )}}">
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
