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
                            <label for="description" data-error="wrong" data-success="right">Description</label>
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
                            <img src="{{ $materialCategory->avatar }}" alt="No Avatar">
                        </div>
                        <div class="input-field col s6 ">
                            <h6 class="custom-label">Update Avatar</h6>
                            <input type="file" class="form-control-file" name="avatar" id="avatar" >
                        </div>
                    </div>
                    <div id="input_fields_wrap" class="col s12 mt-5">
                        <div class="adrs-title col s12">
                            <h5>Reward Points</h5>
                        </div>
                        <div class="input-field col s4">
                            <input id="quantity" name="quantity" type="number" class="validate" value="{{ $materialCategory->quantity }}" readonly >
                            <label for="quantity">Quantity</label>
                            @if ($errors->has('quantity'))
                                <span class="help-block">
                                <strong class="red-text">{{ $errors->first('quantity') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="input-field col s4">
                            {{ Form::select('unit', (['' => 'Choose Unit'] + $units), $materialCategory->unit, ['id' => 'unit']) }}
                            <label for="unit">Product Unit</label>
                            @if ($errors->has('unit'))
                                <span class="help-block">
                                <strong class="red-text">{{ $errors->first('unit') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="input-field col s4">
                            <input id="reward_points" name="reward_points" type="number" class="validate" value="{{ $materialCategory->reward_points }}">
                            <label for="reward-points">Reward Points</label>
                            @if ($errors->has('reward_points'))
                                <span class="help-block">
                                <strong class="red-text">{{ $errors->first('reward_points') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div id="input_fields_wrap" class="col s12">
                        <div class="adrs-title">
                            <h5>Environmental Stats</h5>
                        </div>
                        <div class="input-field col s4">
                            <input id="co2_emission_reduced" type="number" name="co2_emission_reduced" value="{{$materialCategory->co2_emission_reduced}}" step="any" required>
                            <label for="co2_emission_reduced">CO<sub>2</sub> emission reduced (kg)</label>
                            @if ($errors->has('co2_emission_reduced'))
                                <span class="help-block">
                              <strong class="red-text">{{ $errors->first('co2_emission_reduced') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="input-field col s4">
                            <input id="trees_saved" type="number" name="trees_saved" value="{{$materialCategory->trees_saved}}" required>
                            <label for="trees_saved">Trees saved (trees)</label>
                            @if ($errors->has('trees_saved'))
                                <span class="help-block">
                              <strong class="red-text">{{ $errors->first('trees_saved') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="input-field col s4">
                            <input id="oil_saved" type="number" name="oil_saved" value="{{$materialCategory->oil_saved}}" step="any" required>
                            <label for="oil_saved">Oiled saved (ltrs)</label>
                            @if ($errors->has('oil_saved'))
                                <span class="help-block">
                              <strong class="red-text">{{ $errors->first('oil_saved ') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="input-field col s4">
                            <input id="electricity_saved" type="number" name="electricity_saved" value="{{$materialCategory->electricity_saved}}" step="any" required>
                            <label for="electricity_saved">Electricity saved (kwh)</label>
                            @if ($errors->has('electricity_saved'))
                                <span class="help-block">
                              <strong class="red-text">{{ $errors->first('electricity_saved') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="input-field col s4">
                            <input id="water_saved" type="number" name="water_saved" step="any" value="{{$materialCategory->water_saved}}" required>
                            <label for="trees_saved">Water saved (ltrs)</label>
                            @if ($errors->has('water_saved'))
                                <span class="help-block">
                              <strong class="red-text">{{ $errors->first('water_saved') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="input-field col s4">
                            <input id="landfill_space_saved" type="number" name="landfill_space_saved" step="any" value="{{$materialCategory->landfill_space_saved}}" required>
                            <label for="landfill_space_saved">Landfill space saved (ft<sup>3</sup>)</label>
                            @if ($errors->has('water_saved'))
                                <span class="help-block">
                              <strong class="red-text">{{ $errors->first('landfill_space_saved') }}</strong>
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
