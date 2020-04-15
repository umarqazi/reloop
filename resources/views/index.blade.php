@extends('layouts.master')
@section('content')

    <div id="card-stats">
        <div class="row">
            <div class="col s12 m4 l4">
                <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text">
                    <div class="padding-4">
                        <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">add_shopping_cart</i>
                            <p>Total Organizations</p>
                        </div>
                        <div class="col s5 m5 right-align">
                            <h5 class="mb-0">{{ $organizations }}</h5>
                            <p class="no-margin"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m4 l4">
                <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text">
                    <div class="padding-4">
                        <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">perm_identity</i>
                            <p>Total Users</p>
                        </div>
                        <div class="col s5 m5 right-align">
                            <h5 class="mb-0">{{ $users }}</h5>
                            <p class="no-margin"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m4 l4">
                <div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text">
                    <div class="padding-4">
                        <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">timeline</i>
                            <p>Material Categories</p>
                        </div>
                        <div class="col s5 m5 right-align">
                            <h5 class="mb-0">{{ $materialCategories }}</h5>
                            <p class="no-margin"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m4 l4">
                <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text">
                    <div class="padding-4">
                        <div class="col s8 m8">
                            <i class="material-icons background-round mt-5">add_shopping_cart</i>
                            <p>Total Products</p>
                        </div>
                        <div class="col s4 m4 right-align">
                            <h5 class="mb-0">{{ $products }}</h5>
                            <p class="no-margin"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m4 l4">
                <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text">
                    <div class="padding-4">
                        <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">perm_identity</i>
                            <p>Total Requests</p>
                        </div>
                        <div class="col s5 m5 right-align">
                            <h5 class="mb-0">{{ $collectionRequest }}</h5>
                            <p class="no-margin"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m4 l4">
                <div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text">
                    <div class="padding-4">
                        <div class="col s7 m7">
                            <i class="material-icons background-round mt-5">timeline</i>
                            <p>Total Orders</p>
                        </div>
                        <div class="col s5 m5 right-align">
                            <h5 class="mb-0">{{ $orders }}</h5>
                            <p class="no-margin"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="chart"></div>
    <div class="row" style="display: flex">
        <div class="col-6">
            <div id="piechart"></div>
        </div>
        <div class="col-6">
            <div class="col s12">
                <div class="row">
                    <div class="col s12 m6">
                        <div class="card gradient-shadow gradient-45deg-light-blue-cyan border-radius-3">
                            <div class="card-content center">
                                <img src="assets/images/icon/apple-watch.png" class="width-40 border-round z-depth-5">
                                <h5 class="white-text lighten-4">@if(!empty($dashboard->total_trees_saved)){{$dashboard->total_trees_saved}} @else 0 @endif trees</h5>
                                <p class="white-text lighten-4">Trees Saved</p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="card gradient-shadow gradient-45deg-red-pink border-radius-3">
                            <div class="card-content center">
                                <img src="assets/images/icon/printer.png" class="width-40 border-round z-depth-5">
                                <h5 class="white-text lighten-4">@if(!empty($dashboard->total_oil_saved)){{$dashboard->total_oil_saved}} @else 0 @endif ltrs</h5>
                                <p class="white-text lighten-4">Oil Saved</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="card gradient-shadow gradient-45deg-light-blue-cyan border-radius-3">
                            <div class="card-content center">
                                <img src="assets/images/icon/apple-watch.png" class="width-40 border-round z-depth-5">
                                <h5 class="white-text lighten-4">@if(!empty($dashboard->total_electricity_saved)){{$dashboard->total_electricity_saved}} @else 0 @endif Kwh</h5>
                                <p class="white-text lighten-4">Electricity Saved</p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="card gradient-shadow gradient-45deg-red-pink border-radius-3">
                            <div class="card-content center">
                                <img src="assets/images/icon/printer.png" class="width-40 border-round z-depth-5">
                                <h5 class="white-text lighten-4">@if(!empty($dashboard->total_co2_emission_reduced)){{$dashboard->total_co2_emission_reduced}} @else 0 @endif Kg</h5>
                                <p class="white-text lighten-4">CO2 Emission Reduced</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="card gradient-shadow gradient-45deg-light-blue-cyan border-radius-3">
                            <div class="card-content center">
                                <img src="assets/images/icon/apple-watch.png" class="width-40 border-round z-depth-5">
                                <h5 class="white-text lighten-4">@if(!empty($dashboard->total_landfill_space_saved)){{$dashboard->total_landfill_space_saved}} @else 0 @endif ft<sup>3</sup></h5>
                                <p class="white-text lighten-4">Landfill Space Saved</p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="card gradient-shadow gradient-45deg-red-pink border-radius-3">
                            <div class="card-content center">
                                <img src="assets/images/icon/printer.png" class="width-40 border-round z-depth-5">
                                <h5 class="white-text lighten-4">@if(!empty($dashboard->total_water_saved)){{$dashboard->total_water_saved}} @else 0 @endif ltrs</h5>
                                <p class="white-text lighten-4">Water Saved</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="card gradient-shadow gradient-45deg-light-blue-cyan border-radius-3">
                            <div class="card-content center">
                                <img src="assets/images/icon/apple-watch.png" class="width-40 border-round z-depth-5">
                                <h5 class="white-text lighten-4">@if(!empty($dashboard->total_natural_ores_saved)){{$dashboard->total_natural_ores_saved}} @else 0 @endif kg</h5>
                                <p class="white-text lighten-4">Natural Ores Saved</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
