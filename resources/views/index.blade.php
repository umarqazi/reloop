@extends('layouts.dashboard')
@section('content')
    <body>
    <div class="row m-0 cards-row">
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>{{ $organizations }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Total Organizations</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>{{ $users }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>{{ $materialCategories }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Total Material Categories</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>{{ $products }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Total Products</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>{{ $collectionRequest }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Total Collection Requests</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>{{ $orders }}</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Total Orders</p>
                </div>
            </div>
        </div>
    </div>
    <div id="chart"></div>
    <div class="row  mx-0 my-2 charts-top-row">

        {{--Bar Chart--}}
        @include('charts.bar')

        {{--Pie Chart--}}
        @include('charts.pie')
    </div>
    <div class="row m-0 cards-row">
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>@if(!empty($dashboard->total_trees_saved)){{$dashboard->total_trees_saved}} @else 0 @endif trees</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Trees Saved</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>@if(!empty($dashboard->total_oil_saved)){{$dashboard->total_oil_saved}} @else 0 @endif ltrs</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Oil Saved</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>@if(!empty($dashboard->total_electricity_saved)){{$dashboard->total_electricity_saved}} @else 0 @endif Kwh</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Electricity Saved</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>@if(!empty($dashboard->total_co2_emission_reduced)){{$dashboard->total_co2_emission_reduced}} @else 0 @endif Kg</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>CO2 Emission Reduced</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>@if(!empty($dashboard->total_landfill_space_saved)){{$dashboard->total_landfill_space_saved}} @else 0 @endif ft<sup>3</sup></h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>CO2 Emission Reduced</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>@if(!empty($dashboard->total_water_saved)){{$dashboard->total_water_saved}} @else 0 @endif ltrs</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Water Saved</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="inner-wrapper">
                <h5>@if(!empty($dashboard->total_natural_ores_saved)){{$dashboard->total_natural_ores_saved}} @else 0 @endif kg</h5>
                <div class="icon-wrapper">
                    <span><i class="fas fa-shopping-cart"></i></span>
                    <p>Natural Ores Saved</p>
                </div>
            </div>
        </div>
    </div>

    </body>

@endsection
