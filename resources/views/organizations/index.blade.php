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
                            <h5 class="breadcrumbs-title">Organizations</h5>
                            <ol class="breadcrumbs">
                                <li><a href="{{route('home')}}">Dashboard</a>
                                </li>
                                <li class="active">Organizations</li>
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
                           href="{{ route('organization.create') }}">Create</a>
                        <a class="btn btn-primary" href="{{ route('organizations.export') }}">Export</a>
                        <a class="btn btn-danger" href="javascript:void(0)"
                           onclick="$(this).next('input').click()">
                            Import
                        </a>
                        <input type="file" id="import-csv" name="import_csv" style="display: none"/>
                    </div>
                        <div class="col s12">
                        <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Branches</th>
                                <th>Employees</th>
                                <th>Sector</th>
                                <th>Status</th>
                                <th>City</th>
                                <th>District</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($organizations as $organization)
                            <tr>
                                <td>{{ $organization->id }}</td>
                                <td>{{ $organization->org_external_id }}</td>
                                <td>{{ $organization->name }}</td>
                                <td>{{ Str::limit($organization->users->first()->email, 10) }}</td>
                                <td>{{ $organization->users->first()->phone_number }}</td>
                                <td>{{ $organization->no_of_branches }}</td>
                                <td>{{ $organization->no_of_employees }}</td>
                                <td>{{ str_limit($organization->sector->name, 8) }}</td>
                                <td>{{ $organization->users->first()->status == \App\Services\IUserStatus::ACTIVE ? 'Active' : 'Inactive'}}</td>
                                <td>{{ $organization->users->first()->addresses->first()->city->name }}</td>
                                <td>{{ $organization->users->first()->addresses->first()->district->name }}</td>
                                <td>{{ $organization->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('organization.show', $organization->id) }}" class="btn waves-effect waves-light blue accent-2"><i class="fa fa-map-marker"></i></a>
                                    <a href="{{ route('organization.edit', $organization->id) }}" class="btn waves-effect waves-light blue accent-2"><i class="fa fa-edit"></i></a>
                                    {{ Form::open(['url' => route('organization.destroy', $organization->id), 'method' => 'DELETE', 'class' => 'form-inline']) }}
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
