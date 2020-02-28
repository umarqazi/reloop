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
                    <h5 class="breadcrumbs-title">Edit Material Category</h5>
                    <ol class="breadcrumbs">
                        <li>
                            <a href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="active">
                            <a href="{{ route('material-category.index') }}">Material Category</a>
                        </li>
                        <li class="active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="section">
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
            @if(!empty($materialCategory))
                {{ Form::open(['url' => route('material-category.update', $materialCategory->id), 'method' => 'PUT', 'class' => 'row', 'files' => true]) }}
                    <div class="col s12">
                        <div class="input-field col s6">
                            <input id="name" name="name" type="text" value="{{ $materialCategory->name }}" class="validate">
                            <label for="name">First Name</label>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong class="red-text">{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s6">
                            <select class="validate" id="status" name="status">
                                <option value="0" @if($materialCategory->status == 0) selected @endif>Inactive</option>
                                <option value="1" @if($materialCategory->status == 1) selected @endif>Active</option>
                            </select>
                            <label for="status" data-error="wrong" data-success="right">Status</label>
                        </div>
                    </div>

                    <div class="col s12">
                        <div class="input-field col s12">
                            <textarea class="validate materialize-textarea" id="description" name="description">{{ $materialCategory->description }}</textarea>
                            <label for="description" data-error="wrong" data-success="right">Address</label>
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong class="red-text">{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="col s6 box-image">
                            <h6 class="custom-label">Avatar</h6>
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk(env('FILESYSTEM_DRIVER'))->url(config('filesystems.material_category_avatar_upload_path')).$materialCategory->avatar }}" alt="No Avatar">
                        </div>
                        <div class="input-field col s6 ">
                            <h6 class="custom-label">Update Avatar</h6>
                            <input type="file" class="form-control-file" name="avatar" id="avatar" >
                        </div>
                    </div>

                    <div class="col s12">
                        <div class="input-field col s12">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                {{ Form::close() }}
            @endif
            @if ($message = Session::get('empty'))
                <div id="card-alert" class="card red">
                    <div class="card-content white-text">
                        <p>{{ $message }}</p>
                    </div>
                    <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
@endsection
