@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
        </div>
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">Contact Admin</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li class="active">Contact Admin</li>
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
            {{ Form::open(['url' => route('contact-admin'),'method' => 'get',
                           'class' => 'row',]) }}

            <div class="col s12">
                <div class="input-field col s12">
                    <input id="email" type="text" name="email" required value="{{\Illuminate\Support\Facades\Auth::user()->email}}" readonly >
                    <label for="email">Email</label>
                </div>
            </div>

            <div class="col s12">
                <div class="input-field col s12">
                    <input id="subject" type="text" name="subject" required>
                    <label for="subject">Subject</label>
                    @if ($errors->has('subject'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('subject') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s12">
                    <textarea id="message" class="materialize-textarea" name="message" required></textarea>
                    <label for="message">Message</label>
                    @if ($errors->has('message'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('message') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="col s12">
                <div class="input-field col s12">
                    <button type="submit" class="btn btn-primary">Contact Admin</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
