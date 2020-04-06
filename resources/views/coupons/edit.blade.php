
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
                    <h5 class="breadcrumbs-title">Update Coupon</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('coupon.index')}}">Coupons</a>
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
            {{ Form::open(['url' => route('coupon.update',$coupon->id),'method' => 'PUT', 'class' => 'row']) }}
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="code" type="number"  max="99999" min="0" name="code" value="{{ $coupon->code }}" required>
                    <label for="start">Code</label>
                    @if ($errors->has('code'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('code') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <select name="type" id="type" required>
                        <option value="" disabled selected>Choose Coupon Type</option>
                        <option value="1" {{ $coupon->type==1 ? 'selected': '' }} >Fixed</option>
                        <option value="2" {{ $coupon->type==2 ? 'selected': '' }} >Percentage</option>
                    </select>
                    <label for="type">Type</label>
                    @if ($errors->has('type'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('type') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s12">
                    <input id="amount" type="number" max="99999" min="0" name="amount" value="{{ $coupon->amount }}" required>
                    <label for="amount">Amount</label>
                    @if ($errors->has('amount'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('amount') }}</strong>
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
