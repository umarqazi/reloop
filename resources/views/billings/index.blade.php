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
                                <li class="active">Billings</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

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
                                <th>User Email</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($billings as $billing)
                            <tr>
                                <td>{{ $billing->id }}</td>
                                <td>{{ $billing->user->email }}</td>
                                <td>{{ $billing->total }}</td>
                                <td><a href="{{ route('billingListingShow', $billing->id) }}"
                                       class="btn waves-effect waves-light blue accent-2">View</a>
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
