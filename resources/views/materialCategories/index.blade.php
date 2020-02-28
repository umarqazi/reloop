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
                            <h5 class="breadcrumbs-title">Material Categories</h5>
                            <ol class="breadcrumbs">
                                <li>
                                    <a href="{{ route('home') }}">Dashboard</a>
                                </li>
                                <li class="active">Material Categories</li>
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
                        <a class="btn btn-primary" href="{{ route('material-category.create') }}">Create</a>
                    </p>
                    <div class="col s12">
                        <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                            <thead>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            @if(!empty($materialCategories))
                                <tbody>
                                    @foreach($materialCategories as $material)
                                        <tr>
                                            <td>{{ $material->id }}</td>
                                            <td>{{ $material->name }}</td>
                                            <td>{{ ($material->status == 1) ? 'Active' : 'Inactive' }}</td>
                                            <td>
                                                <a class="btn-link" href="{{ route('material-category.edit',$material->id) }}">Edit</a>
                                                {!! Form::open(['method' => 'DELETE','route' => ['material-category.destroy', $material->id],'style'=>'display:inline']) !!}
                                                {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn-link', 'id' => 'btn-remove']) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                            <tfoot>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Status</th>
                                <th>Actions</th>
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
