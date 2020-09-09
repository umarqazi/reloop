@extends('layouts.app')
@section('content')
    <div class="main-loader-wrapper">
        <img src="{{ asset('/assets/images/animation_200_ke9clp83.gif') }}" class="loader-gif">
{{--        <p style="color: #fff;" class="loader-gif-text">Please wait, This may take some time. </p>--}}
    </div>

    <script>
        $(function() {
            $('body').addClass('payment-confirm-page');
        });
    </script>
@endsection
