@extends('layouts.master')
@section('content')

    <div class="container">
        <div class="section">
            <div id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s10 m6 l6">
                            <h5 class="breadcrumbs-title"></h5>
                            <ol class="breadcrumbs">
                                <li>
                                    <a href="{{ route('home') }}">Dashboard</a>
                                </li>
                                <li class="active">Password Reset Requests</li>
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
                        <a class="btn btn-primary" href="{{ route('password-requests.export') }}">Export</a>
                    </p>
                    <div class="col s12">
                        <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>User Email</th>
                                <th>Request Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                    @foreach($requests as $request)
                                        <tr>
                                            <td>{{ $request->id }}</td>
                                            <td>{{ $request->email }}</td>
                                            <td>{{ ($request->status == 0) ? 'New' : 'Completed' }}</td>
                                            <td><a href="{{ route('password-requests.edit', $request->id) }}" class="btn waves-effect waves-light blue accent-2"><i class="fa fa-edit"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            <tfoot>
                            <tr>
                                <th>User ID</th>
                                <th>User Email</th>
                                <th>Request Status</th>
                                <th>Action</th>
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
