@extends('layouts.app')
@section('content')
    <div class="main-wrapper">
        <div class="top-bar">
            <img src="/assets/images/icons/reloop.png">
        </div>
        <div class="container">
            <div class="thanku-wrapper">
                <div class="thanku-wrapper-inner">
                    <img src="/assets/images/logo/logo.png">
                    <p>Are you sure you want to continue?</p>
                    @if(!$tokenName)
                        {!! $form !!}
                    @else
                        <form action="{{ route('confirm-page') }}" method="get">
                            <input type="hidden" name="token_name" value="{{ $form['token_name'] }}">
                            <input type="hidden" name="card_security_code" value="{{ $form['card_security_code'] }}">
                            <input type="submit" value="Submit">
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
