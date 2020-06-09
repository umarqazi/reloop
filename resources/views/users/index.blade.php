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
                        <a class="btn btn-primary" href="{{ route($route.'.export') }}">Export</a>
                    </p>
                    <div class="col s12">
                        <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Remaining Points</th>
                                <th>City</th>
                                <th>District</th>
                                <th>Created at</th>
                                <th>Organization</th>
                                <th>Org Code</th>
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
                                            <td>{{ Str::limit($user->email, 13) }}</td>
                                            <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                            <td>{{ $user->phone_number }}</td>
                                            <td>{{ $user->reward_points ?? '0' }}</td>
                                            <td>{{ ($user->addresses->first()) ? $user->addresses->first()->city->name : 'Not found' }}</td>
                                            <td>{{ ($user->addresses->first()) ? $user->addresses->first()->district->name : 'Not found' }}</td>
                                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                            <td>{{ ($user->organization) ? $user->organization->name : '-' }}</td>
                                            <td>{{ ($user->organization) ? $user->organization->org_external_id : '-' }}</td>
                                        @if($route != '')
                                                <td>
                                                    @if($type ==\App\Services\IUserType::DRIVER)
                                                        <a href="{{ route($route.'.show', $user->id) }}" class="btn waves-effect waves-light blue accent-2"><i class="fa fa-map-marker"></i></a>
                                                    @endif
                                                    <a href="{{ route($route.'.edit', $user->id) }}" class="btn waves-effect waves-light blue accent-2"><i class="fa fa-edit"></i></a>
                                                    {{ Form::open(['url' => route($route.'.destroy', $user->id), 'method' => 'DELETE', 'class' => 'form-inline']) }}
                                                    <button type="submit" class="btn btn-danger red delete"><i class="fa fa-trash "></i></button>
                                                    {{ Form::close() }}
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
