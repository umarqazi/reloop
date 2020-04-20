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
                            <h5 class="breadcrumbs-title">All Users</h5>
                            <ol class="breadcrumbs">
                                <li>
                                    <a href="{{ route('home') }}">Dashboard</a>
                                </li>
                                <li class="active">Users Reward Points</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>


            <div id="card-alert" class="card green hide">
                <div class="card-content white-text">
                    <p></p>
                </div>
                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>


            <div id="table-datatables">
                <div class="row">
                    <div class="col s12">
                        <a class="btn btn-primary" href="{{ route('all-users.export') }}">Export</a>
                    </div>
                    <div class="col s12">
                        <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>User Email</th>
                                    <th>User Type</th>
                                    <th width="20%">Rewards Point(s)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @if(!empty($users))
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ($user->user_type == \App\Services\IUserType::HOUSE_HOLD) ? 'House Hold' : (($user->user_type == \App\Services\IUserType::DRIVER) ? 'Driver' : (($user->user_type == \App\Services\IUserType::SUPERVISOR) ? 'Supervisor' : '')) }}</td>
                                        <td>{{ $user->reward_points ?? '0' }}</td>
                                        <td>
{{--                                            <a href="" id="reward-update" class="btn waves-effect waves-light blue accent-2"><i class="fa fa-refresh"></i></a>--}}
                                            <a href="javascript:void(0)" id="user-{{ $user->id }}" class="edit-user btn btn-primary float-left" data-action="{{ route('get-user', $user->id) }}"><i class="fa fa-edit"></i></a>
                                        </td>
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

    <div class="modal fade" id="userUpdateModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['id' => 'user-update-form', 'route' => 'update-user']) !!}
            {!! Form::hidden('id', '') !!}
            <div class="modal-content">
                <div class="modal-header">
                    <a class="modal-action modal-close btn-link">
                        <i class="fa fa-times text-right"></i>
                    </a>
                </div>

                <div class="modal-body">
                    <div class="form-group @if ($errors->has('reward_points')) has-error @endif">
                        {!! Form::label('Redeem Points') !!}
                        {!! Form::number('redeem_points', null, ['class' => 'form-control', 'placeholder' => 'Enter Redeem Points', 'min' => 0, 'max' => '', 'required']) !!}
                        @if ($errors->has('redeem_points')) <p class="help-block">{{ $errors->first('redeem_points') }}</p> @endif
                        <p class="text-danger redeem_points"></p>
                    </div>
                </div>

                <div class="modal-footer">
                    <a class="modal-action modal-close btn btn-default">Cancel</a>
                    <!-- Submit Form Button -->
                    {!! Form::submit('Update', ['class' => 'btn btn-primary', 'id' => 'user-update']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
