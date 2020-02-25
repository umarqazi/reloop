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
                        <div class="col s2 m6 l6">
                            <a class="btn dropdown-settings waves-effect waves-light breadcrumbs-btn right gradient-45deg-light-blue-cyan gradient-shadow" href="#!" data-activates="dropdown1">
                                <i class="material-icons hide-on-med-and-up">settings</i>
                                <span class="hide-on-small-onl">Settings</span>
                                <i class="material-icons right">arrow_drop_down</i>
                            </a>
                            <ul id="dropdown1" class="dropdown-content">
                                <li><a href="#!" class="grey-text text-darken-2">Access<span class="badge">1</span></a>
                                </li>
                                <li><a href="#!" class="grey-text text-darken-2">Profile<span class="new badge">2</span></a>
                                </li>
                                <li><a href="#!" class="grey-text text-darken-2">Notifications</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="table-datatables">
                <h4 class="header">DataTables example</h4>
                <div class="row">
                    <div class="col s12">
                        <p>DataTables has most features enabled by default, so all you need to do to use it with your
                            own tables is to call the construction function.</p>
                        <p>Searching, ordering, paging etc goodness will be immediately added to the table, as shown in
                            this example.</p>
                    </div>
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
