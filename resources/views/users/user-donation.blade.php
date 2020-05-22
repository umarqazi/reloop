@extends('layouts.master')
@section('content')

    <div class="container">
        <div class="section">
            <div id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s10 m6 l6">
                            <h5 class="breadcrumbs-title">User Donations</h5>
                            <ol class="breadcrumbs">
                                <li>
                                    <a href="{{ route('home') }}">Dashboard</a>
                                </li>
                                <li class="active">User Donations</li>
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
                        <a class="btn btn-primary" href="{{ route('user-donations.export') }}">Export</a>
                    </p>
                    <div class="col s12">
                        <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                            <thead>
                            <tr>
                                <th>User ID</th>
                                <th>User Email</th>
                                <th>Name</th>
                                <th>User Type</th>
                                <th>Phone Number</th>
                                <th>Reward Category</th>
                                <th>Reward Item</th>
                                <th>Redeemed Points</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($userDonations as $userDonation)
                                <tr>
                                    <td>{{$userDonation->user->id}}</td>
                                    <td>{{$userDonation->user->email}}</td>
                                    <td>{{ ($userDonation->user->user_type == 1) ?
                                            $userDonation->user->first_name . ' ' . $userDonation->user->last_name :
                                            $userDonation->user->organization->name  }}
                                    </td>
                                    <td>{{ ($userDonation->user->user_type == \App\Services\IUserType::HOUSE_HOLD ? 'HouseHold' : 'Organization') }}</td>
                                    <td>{{ $userDonation->user->phone_number }}</td>
                                    <td>{{ $userDonation->donationProduct->category->name }}</td>
                                    <td>{{ $userDonation->donationProduct->name }}</td>
                                    <td>{{ $userDonation->donationProduct->redeem_points }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="userSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="modal-action modal-close btn-link">
                        <i class="fa fa-times text-right"></i>
                    </a>
                    <div class="center"><h5>Subscription Detail</h5></div>
                </div>

                <div class="modal-body">
                    <label>Name</label>
                    <input id="subscription-name" type="text" name="name" readonly>
                    <label>Price</label>
                    <input id="subscription-price" type="number" name="price" readonly>
                    <label>Description</label>
                    <textarea id="subscription-description" class="materialize-textarea" name="description" readonly></textarea>
                    <label>Trip(s) Allowed</label>
                    <input id="subscription-request-allowed" type="number" name="request-allowed" readonly>
                    <label>Category</label>
                    <input id="subscription-category" type="text" name="subscription-category-type" readonly>
                </div>

                <div class="modal-footer">
                    <a class="modal-action modal-close btn btn-default">Close</a>
                </div>
            </div>
        </div>
    </div>
@endsection
