{{--@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection--}}

@extends('layouts.app')
@section('content')

    <!-- Start Page Loading -->
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- End Page Loading -->
    <div id="login-page" class="row">
        <div class="col s12 z-depth-4 card-panel">
            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="row">
                    <div class="input-field col s12 center">
                        <img src="/assets/images/logo/login-logo.png" alt="" class="responsive-img">
                        <p class="center login-form-text">Reloop Admin Panel</p>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-3">person_outline</i>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        <label for="email" class="center-align">Email</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-3">lock_outline</i>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l12 ml-2 mt-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Remember me</label>
                    </div>
                </div>
                <div class="row ml-2 mr-2">
                    <div class="input-field col s12">
                        <button type="submit" class="btn waves-effect waves-light col s12">
                            Login
                        </button>
                    </div>
                </div>
                <div class="row ml-2 mr-2">
{{--                    <div class="input-field col s6 m6 l6">--}}
{{--                        <p class="margin medium-small"><a href="page-register.html">Register Now!</a></p>--}}
{{--                    </div>--}}
                    <div class="input-field col s6 m6 l6">
                        <p class="margin right-align medium-small">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    Forgot password ?
                                </a>
                            @endif
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
