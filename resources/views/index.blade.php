@extends('layouts.master')
@section('content')

            <div id="card-stats">
                <div class="row">
                    <div class="col s12 m4 l4">
                        <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text">
                            <div class="padding-4">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">add_shopping_cart</i>
                                    <p>Trees Saved</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h5 class="mb-0">690</h5>
                                    <p class="no-margin">trees</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m4 l4">
                        <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text">
                            <div class="padding-4">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">perm_identity</i>
                                    <p>Oil Saved</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h5 class="mb-0">1885</h5>
                                    <p class="no-margin">ltr</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m4 l4">
                        <div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text">
                            <div class="padding-4">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">timeline</i>
                                    <p>Electricity Saved</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h5 class="mb-0">80</h5>
                                    <p class="no-margin">Kwh</p>
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
                                    <p>CO2 Emission Reduced</p>
                                </div>
                                <div class="col s4 m4 right-align">
                                    <h5 class="mb-0">690</h5>
                                    <p class="no-margin">Kg</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m4 l4">
                        <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text">
                            <div class="padding-4">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">perm_identity</i>
                                    <p>Landfill Space saved</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h5 class="mb-0">1885</h5>
                                    <p class="no-margin">ft<sup>3</sup></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m4 l4">
                        <div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text">
                            <div class="padding-4">
                                <div class="col s7 m7">
                                    <i class="material-icons background-round mt-5">timeline</i>
                                    <p>Water Saved</p>
                                </div>
                                <div class="col s5 m5 right-align">
                                    <h5 class="mb-0">80</h5>
                                    <p class="no-margin">ltr</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="chart"></div>
            <div id="piechart"></div>

@endsection
