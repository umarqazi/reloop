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
                                <li><a href="{{route('collection-requests.index')}}">Collection Requests</a>
                                </li>
                                <li class="active">Request Details</li>
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
                                <li><strong>Created at :</strong><span>{{$request->created_at}}</span></li>
                                <li><strong>Schedule Date :</strong><span>{{$request->collection_date}}</span></li>
                                <li><strong>Status :</strong><span>@if($request->status == \App\Services\IOrderStaus::ORDER_CONFIRMED) Request Confirmed @endif
                                        @if($request->status == \App\Services\IOrderStaus::DRIVER_ASSIGNED) Driver Assigned @endif
                                        @if($request->status == \App\Services\IOrderStaus::DRIVER_DISPATCHED) Driver Dispatched @endif
                                        @if($request->status == \App\Services\IOrderStaus::ORDER_COMPLETED) Request Completed @endif</span></li>
                                <li><strong>Weight Record Comment :</strong><span> {{ $request->additional_comments }} </span></li>
                                @php $count = 0; @endphp
                                @foreach($feedback as $feedBackQuestion)
                                    @php $count++; @endphp
                                    <li><strong>Driver Feedback Q{{ $count }} :</strong><span>{{ $feedBackQuestion->question }}</span></li>
                                    <li><strong>Answer :</strong><span>{{ $feedBackQuestion->answer }}</span></li>
                                @endforeach
                                <li><strong>Feedback Questions Comment :</strong>
                                    <span>{{ (!($feedback->isEmpty())) ? $feedback->first()->additional_comments : '' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col s4">
                        <div class="order-user-detail">
                            <h5>User Detail</h5>
                            <ul>
                                <li><strong>Name :</strong><span>{{ ($request->organization_name) ? $request->organization_name : $request->first_name.' '.$request->last_name}}</span></li>
                                <li><strong>Email :</strong><span>{{$request->user->email}}</span></li>
                                <li><strong>Phone Number :</strong><span>{{$request->phone_number}}</span></li>
                                <li><strong>Location :</strong><span>{{$request->location}}</span></li>
                                <li><strong>City :</strong><span>{{ $request->city->name }}</span></li>
                                <li><strong>District :</strong><span>{{ $request->district->name }}</span></li>
                                <li><strong>User Comment :</strong><span>{{ $request->user_comments }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col s4">
                        <div class="order-user-detail">
                            @if($request->confirm != 1)
                            @if($request->status ==  \App\Services\IOrderStaus::ORDER_COMPLETED)
                            <h5>Confirm Order</h5>
                            {{ Form::open(['url' => route('confirm.request', $request->id), 'method' => 'PUT', 'class' => 'row','id' => $request->id]) }}
                            @else
                            <h5>Assign Driver</h5>
                            {{ Form::open(['url' => route('assign.request', $request->id), 'method' => 'PUT', 'class' => 'row','id' => $request->id]) }}
                            @endif
                            @else
                                <h5>Order Confirmed</h5>
                            @endif
                            <div class="input-field">
                                @if($request->driver_id != NULL)
                                    {{ Form::select('driver_id', (['' => 'Choose Driver'] + $drivers), $request->driver_id, ['id' => 'driver_id','required' => 'required']) }}
                                    <label>Driver</label>
                                @else
                                    {{ Form::select('driver_id', (['' => 'Choose Driver'] + $drivers), null, ['id' => 'driver_id','required' => 'required']) }}
                                    <label>Driver</label>
                                @endif
                            </div>
                            <div class="input-field">
                                @if($request->confirm != 1)
                                @if($request->status ==  \App\Services\IOrderStaus::ORDER_COMPLETED)
                                    <button type="submit" class="btn btn-primary">Confirm</button>
                                @else
                                <button type="submit" class="btn btn-primary">Assign</button>
                                @endif
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
                                <th>Product Category</th>
                                <th>Product Quantity/Weight</th>
                                @if($request->confirm == 0)
                                <th>Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Product Id</th>
                                <th>Product Category</th>
                                <th>Product Quantity/Weight</th>
                                @if($request->confirm == 0)
                                <th>Action</th>
                                @endif
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($request->requestCollection as $requestItem)
                                <tr>
                                    <td>{{ $requestItem->id }}</td>
                                    <td>{{ $requestItem->category_name }}</td>
                                    <td>{{ $requestItem->weight }}</td>
                                    @if($request->confirm == 0)
                                    <td><a href="{{ route('request-collections.edit', $requestItem->id) }}" class="btn waves-effect waves-light blue accent-2"><i class="fa fa-edit"></i></a></td>
                                    @endif
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
