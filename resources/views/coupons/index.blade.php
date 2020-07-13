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
                            <h5 class="breadcrumbs-title">Coupons</h5>
                            <ol class="breadcrumbs">
                                <li><a href="{{route('home')}}">Dashboard</a>
                                </li>
                                <li class="active">Coupons</li>
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
                           href="{{ route('coupon.create') }}">Create</a>
                        <a class="btn btn-primary" href="{{ route('coupons.export') }}">Export</a>
                    </div>
                        <div class="col s12">
                        <table id="data-table-simple" class="display" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Code</th>
                                <th>Max Usage Per User</th>
                                <th>Apply on User Type</th>
                                <th>Apply on Category Type</th>
                                <th>Coupon Type</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->id }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ $coupon->max_usage_per_user }}</td>
                                <td>{{ $coupon->coupon_user_type == \App\Services\IUserType::HOUSE_HOLD ? 'Household' : 'Organization' }}</td>
                                <td>{{ $coupon->coupon_category_type == \App\Services\ICategoryType::SUBSCRIPTION ? 'Service' : 'Product' }}</td>
                                <td>{{ $coupon->type == \App\Services\ICouponType::FIXED ? 'Fixed' : 'Percentage' }}</td>
                                <td>{{ $coupon->amount }}</td>
                                <td>
                                    <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn waves-effect waves-light blue accent-2"><i class="fa fa-edit"></i></a>
                                    {{ Form::open(['url' => route('coupon.destroy', $coupon->id), 'method' => 'DELETE', 'class' => 'form-inline']) }}
                                    <button type="submit" class="btn btn-danger red delete"><i class="fa fa-trash "></i></button>
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
