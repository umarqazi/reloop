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
                            <h5 class="breadcrumbs-title">Subscriptions</h5>
                            <ol class="breadcrumbs">
                                <li><a href="{{route('home')}}">Dashboard</a>
                                </li>
                                <li class="active">Subscriptions</li>
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
                        <a class="btn waves-effect waves-light primary-btn-bgcolor"
                           href="{{ route('subscription.create') }}">Create</a>
                        <a class="btn btn-primary" href="{{ route('subscriptions.export') }}">Export</a>
                    </div>
                        <div class="col s12">
                        <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Category</th>
                                <th>name</th>
                                <th>price</th>
                                <th>Description</th>
                                <th>Request(s) Allowed</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->id }}</td>
                                <td>{{ $subscription->category_id == 1 ? 'Renewable Subscriptions':'One Time Services' }}</td>
                                <td>{{ $subscription->name }}</td>
                                <td>{{ $subscription->price }}</td>
                                <td>{{ $subscription->description }}</td>
                                <td>{{ $subscription->request_allowed }}</td>
                                <td>{{ $subscription->status == 1 ? 'Active':'InActive' }}</td>
                                <td>
                                    <a href="{{ route('subscription.edit', $subscription->id) }}" class="btn waves-effect waves-light blue accent-2"><i class="fa fa-edit"></i></a>
                                    {{ Form::open(['url' => route('subscription.destroy', $subscription->id), 'method' => 'DELETE', 'class' => 'form-inline']) }}
                                    <button type="submit" class="btn btn-danger red"><i class="fa fa-trash "></i></button>
                                    {{ Form::close() }}
                                </td>
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
