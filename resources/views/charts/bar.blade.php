<div class="col-md-6">
    <div class="chart-wrapper" id="bar-chart-container">
        <div class="chart-loader" style="display: none;">Loading ...</div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="day-tab" data-toggle="tab" href="#day" role="tab" aria-controls="profile" aria-selected="false">Daily</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="week-tab" data-toggle="tab" href="#week" role="tab" aria-controls="profile" aria-selected="false">Weekly</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="month-tab" data-toggle="tab" href="#month" role="tab" aria-controls="contact" aria-selected="false">Monthly</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="year-tab" data-toggle="tab" href="#year" role="tab" aria-controls="contact" aria-selected="false">yearly</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            {{--Daily Chart View--}}
            <div class="tab-pane fade show active" id="day" role="tabpanel" aria-labelledby="day-tab">
                <div class="charts-wrapper" id="bar-daily-view"></div>
            </div>

            <div class="tab-pane fade" id="week" role="tabpanel" aria-labelledby="week-tab">
                <input type="hidden" name="activeQuarter" value="{{ \App\Helpers\ResponseHelper::getActiveWeek() }}">
                <div class="owl-carousel month-view-slider">
                    @for($i = 1; $i <= \App\Helpers\ResponseHelper::getActiveWeek(false); $i ++)
                        <div class="month-slider">
                            <h3>Week {{ $i }} <span>({{ now()->format('Y') }})</span></h3>
                            <div class="charts-wrapper" id="bar-weekly-view-q{{ $i }}"></div>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="tab-pane fade" id="month" role="tabpanel" aria-labelledby="month-tab">
                <div class="owl-carousel month-view-slider">
                    @for($i = 1; $i <= now()->format('m'); $i ++)
                        <div class="month-slider">
                            <h3>{{ now()->month($i)->format('M') }}<span>({{ now()->format('Y') }})</span></h3>
                            <div class="charts-wrapper" id="chartContainer-jan"></div>
                        </div>
                    @endfor
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