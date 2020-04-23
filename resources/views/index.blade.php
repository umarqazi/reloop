@extends('layouts.master')
@section('content')
    <head>
        <link href="/assets/css/chart/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="/assets/css/chart/charts.css" type="text/css" rel="stylesheet">
        <link href="/assets/css/chart/main.css" type="text/css" rel="stylesheet">
        <link href="/assets/css/chart/owl.carousel.min.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    </head>
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
        <div class="col-md-6">
            <div class="chart-wrapper">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="week-tab" data-toggle="tab" href="#week" role="tab" aria-controls="profile" aria-selected="false">Week</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="month-tab" data-toggle="tab" href="#month" role="tab" aria-controls="contact" aria-selected="false">Month</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="year-tab" data-toggle="tab" href="#year" role="tab" aria-controls="contact" aria-selected="false">year</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="week" role="tabpanel" aria-labelledby="week-tab">
                        <div class="owl-carousel month-view-slider">
                            <div class="month-slider">
                                <h3>Week 1 <span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-week1"></div>
                            </div>
                            <div class="month-slider">
                                <h3>Week 2 <span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-week2"></div>
                            </div>
                            <div class="month-slider">
                                <h3>Week 3 <span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-week3"></div>
                            </div>
                            <div class="month-slider">
                                <h3>Week 4 <span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-week4"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="month" role="tabpanel" aria-labelledby="month-tab">
                        <div class="owl-carousel month-view-slider">
                            <div class="month-slider">
                                <h3>January<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-jan"></div>
                            </div>
                            <div class="month-slider">
                                <h3>February<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-feb"></div>
                            </div>
                            <div class="month-slider">
                                <h3>March<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-mar"></div>
                            </div>
                            <div class="month-slider">
                                <h3>April<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-apr"></div>
                            </div>
                            <div class="month-slider">
                                <h3>May<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-may"></div>
                            </div>
                            <div class="month-slider">
                                <h3>June<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-jun"></div>
                            </div>
                            <div class="month-slider">
                                <h3>July<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-jul"></div>
                            </div>
                            <div class="month-slider">
                                <h3>August<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-aug"></div>
                            </div>
                            <div class="month-slider">
                                <h3>September<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-sep"></div>
                            </div>
                            <div class="month-slider">
                                <h3>October<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-oct"></div>
                            </div>
                            <div class="month-slider">
                                <h3>November<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-nov"></div>
                            </div>
                            <div class="month-slider">
                                <h3>December<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-dec"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="year" role="tabpanel" aria-labelledby="year-tab">
                        <div class="owl-carousel month-view-slider">
                            <div class="month-slider">
                                <h3>Year<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-quart-1"></div>
                            </div>
                            <div class="month-slider">
                                <h3>Year<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-quart-2"></div>
                            </div>
                            <div class="month-slider">
                                <h3>Year<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-quart-3"></div>
                            </div>
                            <div class="month-slider">
                                <h3>Year<span>(2019)</span></h3>
                                <div class="charts-wrapper" id="chartContainer-quart-4"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="pie-chart-wrapper">
                <canvas id="myChart"></canvas>
                <div id="legend"></div>
            </div>
        </div>
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
