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
                            <h5 class="breadcrumbs-title">Products</h5>
                            <ol class="breadcrumbs">
                                <li><a href="index.html">Dashboard</a>
                                </li>
                                <li class="active">Products</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div id="table-datatables">
                <div class="row">
                    <a class="btn waves-effect waves-light primary-btn-bgcolor" href="products/create">Create</a>
                    <div class="col s12">
                        <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Product Price</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Product Name</th>
                                <th>Product Price</th>
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
