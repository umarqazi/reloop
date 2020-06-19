@extends('layouts.master')
@section('content')

    <div class="container">
        <div class="section">
            <div id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s10 m6 l6">
                            <h5 class="breadcrumbs-title">Billings</h5>
                            <ol class="breadcrumbs">
                                <li><a href="{{route('home')}}">Dashboard</a>
                                </li>
                                <li><a href="{{route('billing-listing')}}">Billings</a>
                                </li>
                                <li class="active">Billing Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="details-section">
                <div class="row">
                    <div class="col s4">
                        <div class="order-user-detail">
                            <h5>Billing Detail</h5>
                            <ul>
                                <li><strong>Id :</strong><span>{{ $billingDetails->id }}</span></li>
                                @if($billingDetails->subscription_id)
                                    <li><strong>Service Name :</strong><span>{{ $billingDetails->subscription->name }}</span></li>
                                    <li><strong>Service Price :</strong><span>{{ $billingDetails->subscription->price }}</span></li>
                                    <li><strong>Coupon Code :</strong><span>{{ ($billingDetails->coupon) ?? '-' }}</span></li>
                                @else
                                    @foreach($billingDetails->orderItems as $orderItem)
                                        <li><strong>Product Name :</strong><span>{{ $orderItem->product->name }}</span></li>
                                        <li><strong>Product Price :</strong><span>{{ $orderItem->product->price }}</span></li>
                                    @endforeach
                                        <li><strong>Coupon Code :</strong><span>{{ ($billingDetails->coupon_discount) ?? '-' }}</span></li>
                                @endif
                                <li><strong>Created at :</strong><span>{{ $billingDetails->created_at }}</span></li>
                                <li><strong>Total :</strong><span>{{ $billingDetails->total }}</span></li>
                                <li><strong>Status :</strong>
                                    <span>
                                        @if($billingDetails->status == \App\Services\IOrderStaus::ORDER_CONFIRMED) Order Confirmed @endif
                                        @if($billingDetails->status == \App\Services\IOrderStaus::DRIVER_ASSIGNED) Driver Assigned @endif
                                        @if($billingDetails->status == \App\Services\IOrderStaus::DRIVER_DISPATCHED) Driver Dispatched @endif
                                        @if($billingDetails->status == \App\Services\IOrderStaus::ORDER_COMPLETED) Order Completed @endif
                                        @if($billingDetails->status == \App\Services\IOrderStaus::ORDER_CANCELLED) Order Cancelled @endif
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col s4">
                        <div class="order-user-detail">
                            <h5>User Detail</h5>
                            <ul>
                                <li><strong>Name :</strong>
                                    <span>
                                        {{ ($billingDetails->user->user_type == 2) ? $billingDetails->user->organization->name : $billingDetails->user->first_name.' '.$billingDetails->user->last_name }}
                                    </span></li>
                                <li><strong>Email :</strong><span>{{$billingDetails->user->email}}</span></li>
                                <li><strong>Phone Number :</strong><span>{{$billingDetails->user->phone_number}}</span></li>
                                <li><strong>Location :</strong><span>{{$billingDetails->user->addresses->first()->location}}</span></li>
                                <li><strong>City :</strong><span>{{ $billingDetails->user->addresses->first()->city->name }}</span></li>
                                <li><strong>District :</strong><span>{{ $billingDetails->user->addresses->first()->district->name }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
