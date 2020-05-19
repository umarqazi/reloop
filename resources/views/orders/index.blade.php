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
                            <h5 class="breadcrumbs-title">Orders</h5>
                            <ol class="breadcrumbs">
                                <li><a href="{{route('home')}}">Dashboard</a>
                                </li>
                                <li class="active">Orders</li>
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
                                <a class="btn btn-primary" href="{{ route('userOrders.export') }}">Export</a>
                            </p>
                        <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Order Number</th>
                                <th>Email</th>
                                <th>Order Status</th>
                                <th>Order City</th>
                                <th>Order District</th>
                                <th>Order Created at</th>
                                <th>Total</th>
                                <th>Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->order_number  }}</td>
                                <td>{{ $order->email }}</td>
                                <td>@if($order->status == \App\Services\IOrderStaus::ORDER_CONFIRMED) Order Confirmed @endif
                                    @if($order->status == \App\Services\IOrderStaus::DRIVER_ASSIGNED) Driver Assigned @endif
                                    @if($order->status == \App\Services\IOrderStaus::DRIVER_DISPATCHED) Order Dispatched @endif
                                    @if($order->status == \App\Services\IOrderStaus::ORDER_COMPLETED) Order Completed @endif</td>
                                <td>{{ $order->city->name }}</td>
                                <td>{{ $order->district->name }}</td>
                                <td>{{ $order->created_at->format('Y-m-d')}}</td>
                                <td>{{ $order->total }}</td>
                                <td><a href="{{ route('orders.show', $order->id) }}" class="btn waves-effect waves-light blue accent-2">View</a></td>
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
