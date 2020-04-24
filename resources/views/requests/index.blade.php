@extends('layouts.master')
@section('content')

    <div class="container">
        <div class="section">
            <div id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s10 m6 l6">
                            <h5 class="breadcrumbs-title">Collection Requests</h5>
                            <ol class="breadcrumbs">
                                <li><a href="{{route('home')}}">Dashboard</a>
                                </li>
                                <li class="active">Collection Requests</li>
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
                        <div class="col s12">
                            <p class="col s12">
                                <a class="btn btn-primary" href="{{ route('requests.export') }}">Export</a>
                            </p>
                        <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Request Number</th>
                                <th>Email</th>
                                <th>Request Status</th>
                                <th>Request City</th>
                                <th>Request District</th>
                                <th>Collection Date</th>
                                <th>Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($requests as $request)
                            <tr>
                                <td>{{ $request->id }}</td>
                                <td>{{ $request->request_number  }}</td>
                                <td>{{ $request->user->email }}</td>
                                <td>@if($request->status == \App\Services\IOrderStaus::ORDER_CONFIRMED) Request Confirmed @endif
                                    @if($request->status == \App\Services\IOrderStaus::DRIVER_ASSIGNED) Driver Assigned @endif
                                    @if($request->status == \App\Services\IOrderStaus::DRIVER_DISPATCHED) Driver Dispatched @endif
                                    @if($request->status == \App\Services\IOrderStaus::ORDER_COMPLETED) Request Completed @endif</td>
                                <td>{{ $request->city }}</td>
                                <td>{{ $request->district }}</td>
                                <td>{{ $request->collection_date}}</td>
                                <td><a href="{{ route('collection-requests.show', $request->id) }}" class="btn waves-effect waves-light blue accent-2">View</a></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
