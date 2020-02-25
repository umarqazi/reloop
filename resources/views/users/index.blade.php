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
                            <h5 class="breadcrumbs-title">Forms</h5>
                            <ol class="breadcrumbs">
                                <li><a href="#">Dashboard</a>
                                </li>
                                <li class="active">Users</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div id="table-datatables">
                <div class="row">
                    <div class="col s12">
                        <p>DataTables has most features enabled by default, so all you need to do to use it with your
                            own tables is to call the construction function.</p>
                        <p>Searching, ordering, paging etc goodness will be immediately added to the table, as shown in
                            this example.</p>
                    </div>
                    <p>
                        <a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" href="{{ route('user.create') }}">Create</a>
                    </p>
                    <div class="col s12">
                        <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                            <thead>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>User Type</th>
                                <th>Earned points</th>
                                <th>User status</th>
                                <th>Total Orders</th>
                                <th>Last activity</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>User Type</th>
                                <th>Earned points</th>
                                <th>User status</th>
                                <th>Total Orders</th>
                                <th>Last activity</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
