@extends('layouts.app')
@section('content')
    <div class="main-wrapper">
        <div class="thanku-wrapper">
            <div class="thanku-wrapper-inner">
                <img src="{{ asset('/assets/images/logo/logo.png') }}">
                <p>Are you sure you want to continue?</p>
                @if(!$tokenName)
                    {!! $form !!}
                @else
                    <form action="{{ route('confirm-page') }}" method="get">
                        <input type="hidden" name="token_name" value="{{ $form['token_name'] }}">
                        <input type="hidden" name="card_security_code" value="{{ $form['card_security_code'] }}">
                        <input type="submit" value="Confirm" class="confirm-btn">
                    </form>
                @endif
            </div>
            <div class="main-loader">
                <img src="{{ asset('/assets/images/animation_200_ke9clp83.gif') }}" class="loader-gif" style="display: none">
{{--                <p style="color: #fff; display: none" class="loader-gif-text">Please wait, This may take some time. </p>--}}
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('body').addClass('payment-confirm-page');

            $('.confirm-btn').click(function (){
                $('.thanku-wrapper-inner').hide();
                $('.loader-gif, .loader-gif-text').show();
            });
        });
    </script>
@endsection
