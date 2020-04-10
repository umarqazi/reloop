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
                            <h5 class="breadcrumbs-title">Collection Requests</h5>
                            <ol class="breadcrumbs">
                                <li><a href="{{route('home')}}">Dashboard</a>
                                </li>
                                <li><a href="{{route('collection-requests.index')}}">Collection Requests</a>
                                </li>
                                <li class="active">Collection Request Details</li>
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

            <div class="details-section">
                <div class="row">
                    <div class="col s4">
                        <div class="order-user-detail">
                            <h5>Order Detail</h5>
                            <ul>
                                <li><strong>Id :</strong><span>{{$request->id}}</span></li>
                                <li><strong>Number :</strong><span>{{$request->request_number}}</span></li>
                                <li><strong>Date :</strong><span>{{$request->created_at->format('Y-m-d')}}</span></li>
                                <li><strong>Status :</strong><span>@if($request->status == \App\Services\IOrderStaus::ORDER_CONFIRMED) Request Confirmed @endif
                                        @if($request->status == \App\Services\IOrderStaus::DRIVER_ASSIGNED) Driver Assigned @endif
                                        @if($request->status == \App\Services\IOrderStaus::DRIVER_DISPATCHED) Driver Dispatched @endif
                                        @if($request->status == \App\Services\IOrderStaus::ORDER_COMPLETED) Request Completed @endif</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col s4">
                        <div class="order-user-detail">
                            <h5>User Detail</h5>
                            <ul>
                                <li><strong>Name :</strong><span>{{$request->first_name.' '.$request->last_name}}</span></li>
                                <li><strong>Email :</strong><span>{{$request->user->email}}</span></li>
                                <li><strong>Phone Number :</strong><span>{{$request->phone_number}}</span></li>
                                <li><strong>Location :</strong><span>{{$request->location}}</span></li>
                                <li><strong>City :</strong><span>{{$request->city}}</span></li>
                                <li><strong>District :</strong><span>{{$request->district}}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col s4">
                        <div class="order-user-detail">
                            <h5>Assign Driver</h5>
                            {{ Form::open(['url' => route('supervisor.assign.order', $request->id), 'method' => 'PUT', 'class' => 'row','id' => $request->id]) }}

                            <div class="input-field">
                                 {{--   {{ Form::select('driver_id', (['' => 'Choose Driver'] + $drivers), $request->driver_id, ['id' => 'driver_id','required' => 'required']) }}
                                 --}}   <label>Driver</label>
                            </div>
                            <div class="input-field">
                                <button type="submit" class="btn btn-primary">Assign</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>




            <div id="table-datatables">
                <div class="row">
                    <div class="col s12">
                        <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Product Id</th>
                                <th>Product Category</th>
                                <th>Product Quantity/Weight</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Product Id</th>
                                <th>Product Category</th>
                                <th>Product Quantity/Weight</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($request->requestCollection as $requestItem)
                                <tr>
                                    <td>{{ $requestItem->id }}</td>
                                    <td>{{ $requestItem->category_name }}</td>
                                    <td>{{ $requestItem->weight }}</td>
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
