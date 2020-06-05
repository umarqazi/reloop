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
                                <th>ID</th>
                                <th>Request Number</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>City</th>
                                <th>District</th>
                                <th>Collection Date</th>
                                <th>Comments</th>
                                <th>Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($requests as $request)
                            <tr>
                                <td>{{ $request->id }}</td>
                                <td>{{ $request->request_number  }}</td>
                                <td>{{ $request->user->email }}</td>
                                <td>{{ ($request->user->user_type == \App\Services\IUserType::HOUSE_HOLD) ?
                                        $request->first_name . ' ' . $request->last_name :
                                        $request->organization_name  }}
                                </td>
                                <td>{{ $request->phone_number }}</td>
                                <td>@if($request->status == \App\Services\IOrderStaus::ORDER_CONFIRMED) New @endif
                                    @if($request->status == \App\Services\IOrderStaus::DRIVER_ASSIGNED) Assigned @endif
                                    @if($request->status == \App\Services\IOrderStaus::DRIVER_DISPATCHED) Dispatched @endif
                                    @if($request->status == \App\Services\IOrderStaus::ORDER_COMPLETED) Completed @endif</td>
                                <td>{{ $request->city->name }}</td>
                                <td>{{ $request->district->name }}</td>
                                <td>{{ $request->collection_date }}</td>
                                <td>{{ str_limit($request->user_comments, $limit = 10, $end = '...') }}</td>
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
