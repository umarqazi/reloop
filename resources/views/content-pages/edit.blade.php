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
                    <h5 class="breadcrumbs-title">Update Page</h5>
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Dashboard</a>
                        </li>
                        <li><a href="{{route('pages.index')}}">Pages</a>
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
            {{ Form::open(['url' => route('pages.update',$page->id),'method' => 'PUT', 'class' => 'row']) }}
            <div class="col s12">
                <div class="input-field col s12">
                    <input id="title" type="text" name="title" value="{{ $page->title }}"  readonly required>
                    <label for="name">Title</label>
                    @if ($errors->has('title'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('title') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s12">
                    <textarea id="body" class="materialize-textarea" name="body" required>{{ $page->body }}</textarea>
                    <label for="body">Body</label>
                    @if ($errors->has('body'))
                        <span class="help-block">
                        <strong class="red-text">{{ $errors->first('body') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col s12">
                <div class="input-field col s12">
                    <button type="submit" class="btn btn-primary update">Update</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
