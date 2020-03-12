@extends('layouts.master')
@section('content')

    <div class="container">
        <div class="section">
            <div id="breadcrumbs-wrapper">
                <!-- Search for small screen -->
                <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
                    <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col s10 m6 l6">
                            <h5 class="breadcrumbs-title">{{ ($type == 1) ? 'Users' : (($type == 3) ? 'Drivers' : (($type == 4) ? 'Supervisors' : '')) }}</h5>
                            <ol class="breadcrumbs">
                                <li>
                                    <a href="{{ route('home') }}">Dashboard</a>
                                </li>
                                <li class="active">{{ ($type == 1) ? 'Users' : (($type == 3) ? 'Drivers' : (($type == 4) ? 'Supervisors' : '')) }}</li>
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

            <div id="table-datatables">
                <div class="row">
                    <p class="col s12">
                        @php
                            $route = '';
                            if($type){
                                $route = ($type == 1) ? 'user' : (($type == 3) ? 'driver' : (($type == 4) ? 'supervisor' : ''));
                            }
                        @endphp
                        @if($route != '' && $type != 1)
                            <a class="btn btn-primary" href="{{ route($route.'.create') }}">Create</a>
                        @endif
                    </p>
                    <div class="col s12">
                        <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                            <thead>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>User Type</th>
                                <th>Rewards Points</th>
                                <th>User Status</th>
                                {{--<th>Total Orders</th>
                                <th>Last Activity</th>--}}
                                @if($route != '')
                                    <th>Action</th>
                                @endif
                            </tr>
                            </thead>
                            @if(!empty($users))
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->first_name .' '. $user->last_name}}</td>
                                                <td>{{ ($user->user_type == \App\Services\IUserType::HOUSE_HOLD) ? 'House Hold' : (($user->user_type == \App\Services\IUserType::DRIVER) ? 'Driver' : (($user->user_type == \App\Services\IUserType::SUPERVISOR) ? 'Supervisor' : '')) }}</td>
                                            <td>{{ $user->reward_points ?? '0' }}</td>
                                            <td>{{ ($user->status == 1) ? 'Active' : 'Inactive' }}</td>
                                            @if($route != '')
                                                <td>
                                                    <a href="{{ route($route.'.edit', $user->id) }}" class="btn waves-effect waves-light blue accent-2"><i class="fa fa-edit"></i></a>
                                                    {{ Form::open(['url' => route($route.'.destroy', $user->id), 'method' => 'DELETE', 'class' => 'form-inline']) }}
                                                    <button type="submit" class="btn btn-danger red"><i class="fa fa-trash "></i></button>
                                                    {{ Form::close() }}
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                            <tfoot>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>User Type</th>
                                <th>Earned points</th>
                                <th>User status</th>
                                {{--<th>Total Orders</th>
                                <th>Last Activity</th>--}}
                                @if($route != '')
                                    <th>Action</th>
                                @endif
                            </tr>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
