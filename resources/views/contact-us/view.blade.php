@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">View</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('contact-us.index')}}">Contact Us</a>
                        </li>
                        <li class="active">View</li>
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
            <div class="col s12">
                <div class="input-field col s6">
                    <input id="email" type="text" name="email" value="{{ $contactUs->email }}" readonly >
                    <label for="email">Email</label>
                </div>
                <div class="input-field col s6">
                    <input id="subject" type="text"  value="{{ $contactUs->subject }}" readonly>
                    <label for="subject">Subject</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s12">
                    <textarea id="message" class="materialize-textarea" name="message" readonly>{{ $contactUs->message }}</textarea>
                    <label for="message">Message</label>
                </div>
            </div>

        </div>
    </div>
@endsection
