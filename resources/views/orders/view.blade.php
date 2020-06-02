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
                                <li><a href="{{route('orders.index')}}">Orders</a>
                                </li>
                                <li class="active">Order Details</li>
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
                                <li><strong>Id :</strong><span>{{$order->id}}</span></li>
                                <li><strong>Number :</strong><span>{{$order->order_number}}</span></li>
                                <li><strong>Date :</strong><span>{{$order->created_at->format('Y-m-d')}}</span></li>
                                <li><strong>Status :</strong><span>@if($order->status == \App\Services\IOrderStaus::ORDER_CONFIRMED) Order Confirmed @endif
                                        @if($order->status == \App\Services\IOrderStaus::DRIVER_ASSIGNED) Driver Assigned @endif
                                        @if($order->status == \App\Services\IOrderStaus::DRIVER_DISPATCHED) Order Dispatched @endif
                                        @if($order->status == \App\Services\IOrderStaus::ORDER_COMPLETED) Order Completed @endif</span></li>
                                <li><strong>Redeem Points :</strong><span>{{$order->redeem_points == null ? 'None' : $order->redeem_points}}</span></li>
                                <li><strong>Coupon Discount :</strong><span>{{$order->coupon_discount == null ? 'None' : $order->coupon_discount}}</span></li>
                                <li><strong>Subtotal :</strong><span>{{$order->subtotal}}</span></li>
                                <li><strong>Total :</strong><span>{{$order->total}}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col s4">
                        <div class="order-user-detail">
                            <h5>User Detail</h5>
                            <ul>
                                <li><strong>Name :</strong>
                                    <span>
                                        {{ ($order->user->user_type == \App\Services\IUserType::HOUSE_HOLD) ?
                                        $order->first_name . ' ' . $order->last_name :
                                        $order->organization_name  }}
                                    </span>
                                </li>
                                <li><strong>Email :</strong><span>{{$order->email}}</span></li>
                                <li><strong>Phone Number :</strong><span>{{$order->phone_number}}</span></li>
                                <li><strong>Location :</strong><span>{{$order->location}}</span></li>
                                <li><strong>City :</strong><span>{{$order->city->name}}</span></li>
                                <li><strong>District :</strong><span>{{$order->district->name}}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col s4">
                        <div class="order-user-detail">
                            <h5>Assign Driver</h5>
                            {{ Form::open(['url' => route('supervisor.assign.order', $order->id), 'method' => 'PUT', 'class' => 'row','id' => $order->id]) }}
                            <div class="input-field">
                                @if($order->delivery_date == NULL)
                                    <input id="delivery_date" name="delivery_date" placeholder="Delivery Date" type="date"  required >
                                @else
                                    <input id="delivery_date" name="delivery_date" placeholder="Delivery Date" type="date"  value="{{ $order->delivery_date }}" required >
                                @endif
                            </div>

                            <div class="input-field">
                                @if($order->driver_id != NULL)
                                    {{ Form::select('driver_id', (['' => 'Choose Driver'] + $drivers), $order->driver_id, ['id' => 'driver_id','required' => 'required']) }}
                                    <label>Driver</label>
                                @else
                                    <div id="driver_id_div">
                                    </div>
                                @endif
                            </div>
                            <div class="input-field">
                                @if($order->status != \App\Services\IOrderStaus::ORDER_COMPLETED)
                                    <button type="submit" class="btn btn-primary">Assign</button>
                                @endif
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
                                <th>Product Name</th>
                                <th>Product Quantity</th>
                                <th>Product Price</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Product Id</th>
                                <th>Product Name</th>
                                <th>Product Quantity</th>
                                <th>Product Price</th>
                                <th>Total</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($order->orderItems as $orderItem)
                                <tr>
                                    <td>{{ $orderItem->product_id }}</td>
                                    <td>{{ $orderItem->product->name }}</td>
                                    <td>{{ $orderItem->quantity }}</td>
                                    <td>{{ $orderItem->product->price }}</td>
                                    <td>{{ $orderItem->price }}</td>
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
