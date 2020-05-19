"use strict";

/**
 * Send XMLHttpRequest
 *
 * @param url
 * @param type
 * @param data
 * @param loading
 * @param form
 * @param contentType
 * @returns {Promise<void>}
 */
const ajaxRequest = async function (url, type, data, loading = true, form = null, contentType = 'true') {
    setHeaders();
    let settings = {
        url: url,
        type: type,
        data: data,
        processData: true,
        beforeSend: () => {
            (loading) ? $('.loader').show() : '';
        },

        success: (res) => {
            (loading) ? $('.loader').hide() : '';

            if (!res.status) {
                if (res.msg !== undefined) {
                    if (res.msg !== '' && res.msg !== null) {
                        //toastr.error(res.msg);
                    }
                }
                return false;
            }

            if (res.status) {
                if (res.msg !== '' && res.msg !== null) {
                    //toastr.success(res.msg);
                }
                return res;
            }
        },

        error: (err) => {
            (loading) ? $('.loader').hide() : '';
        }

    };
    if (contentType === 'false') {
        settings.processData = false;
        settings.contentType = false;
    }

    return await $.ajax(settings);
};

/**
 * Set Default Request Headers
 */
const setHeaders = function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        }
    });
};

/**
 *
 * Return Active Filter
 *
 * @param selector
 * @returns {jQuery}
 */
const activeFilter = function (selector) {
    return $(selector).find('li > a.active').text().toLowerCase();
};

/**
 * Active & De-active Loader
 *
 * @param state
 */
const loader = function(state) {
    let loader = $('.chart-loader');
    if(state === 'enable')
    {
       loader.show();
       return ;
    }

    loader.hide();
};

/**
 * Return users object having user drop-down data
 *
 * @returns {{users: {organizationId: jQuery, driverId: jQuery, supervisorId: jQuery, userId: jQuery}}}
 */
const getUsersData = function () {
    return {
        users: {
            userId: $('#user_id:enabled').val(),
            organizationId: $('#organization_id:enabled').val(),
            driverId: $('#driver_id:enabled').val(),
            supervisorId: $('#supervisor_id:enabled').val()
        }
    };
}

/**
 * BarChart Fetcher
 *
 * @param filter
 * @param date
 * @returns {Promise<void>}
 */
const barChartRequest = async function(filter, date = null) {
    return await ajaxRequest(
        `get-barChart-data`,
        'post',
        {
            filter: filter,
            date: date,
            ...getUsersData()
        }
    );
};

/**
 * BarChart Fetcher
 *
 * @param data
 * @returns {Promise<void>}
 */
const pieChartRequest = async function(data = null) {
    data = {
        ...data,
        ...getUsersData()
    };
    return await ajaxRequest(`get-pieChart-data`, 'post', data);
};

/**
 * Draw Bar Chart
 *
 * @param activeFilter
 * @param dataPoints
 */
const drawBarChart = function (activeFilter, dataPoints) {
    // Dynamically active quarter
    // $(".month-view-slider").trigger("to.owl.carousel", [1, 1]);
    var chart = new CanvasJS.Chart(`bar-${activeFilter}-view`, {
        animationEnabled: true,
        title: {
            text: ''
        },
        theme: "light2",
        data: [{
            type: "column",
            legendText: "",
            dataPoints: dataPoints,
            click: async function(e){
                // pie chart logic
                await pieChartRequest(e.dataPoint.data).then(res => {
                    if (res) {
                        drawPieChart(res);
                    }
                });
            },
        }]
    });

    chart.render();
};

/**
 * Draw Pie Chart
 *
 * @param dataPoints
 */
let chart;
const drawPieChart = function (dataPoints) {
    var ctx = document.getElementById("myChart").getContext('2d');

    // Destroy chart if already drawn.
    if(typeof chart === "object") {
        chart.destroy();
    }

    chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: dataPoints.labels,
            datasets: [{
                backgroundColor: [
                    "#2ecc71",
                    "#3498db",
                    "#95a5a6",
                    "#9b59b6",
                    "#f1c40f",
                    "#e74c3c",
                    "#34495e"
                ],
                data: dataPoints.data
            }]
        },
        options: {
            legend: {
                display: false
            },
        }
    });

    var myLegendContainer = document.getElementById("legend");
    // generate HTML legend
    myLegendContainer.innerHTML = chart.generateLegend();
    // bind onClick event to all LI-tags of the legend
    var legendItems = myLegendContainer.getElementsByTagName('li');
    for (var i = 0; i < legendItems.length; i += 1) {
        legendItems[i].addEventListener("click", legendClickCallback, false);
    }

    function legendClickCallback(event) {
        event = event || window.event;

        var target = event.target || event.srcElement;
        while (target.nodeName !== 'LI') {
            target = target.parentElement;
        }
        var parent = target.parentElement;
        var chartId = parseInt(parent.classList[0].split("-")[0], 10);
        var chart = Chart.instances[chartId];
        var index = Array.prototype.slice.call(parent.children).indexOf(target);
        var meta = chart.getDatasetMeta(0);
        var item = meta.data[index];

        if (item.hidden === null || item.hidden === false) {
            item.hidden = true;
            target.classList.add('hidden');
        } else {
            target.classList.remove('hidden');
            item.hidden = null;
        }
        chart.update();
    }
};


window.onload = async function () {

    loader('enable');
    let $body = $('body');

    // Draw charts on page loaded.
    drawCharts();

    /**
     * Draw charts of selected date
     */
    $body.on('click', '.tab-pane .fa-chevron-left, .tab-pane .fa-chevron-right', function () {
        // Drw charts with respect to given date.
        drawCharts($(this).data('date'));
    });

    // Select New Filter Listener
    $body.on('click', '#myTab', function () {
        // Draw charts when click on tab.
        drawCharts();
    });
};

/**
 * Draw Charts
 * Renders Bar and Pie charts after getting datapoints.
 *
 * @param date
 */
const drawCharts = function (date = null) {
    setTimeout(() => {
        // Fetching the current filter
        let currentFilter = activeFilter('#myTab');

        // Send Request for both charts for current filter
        barChartRequest(currentFilter, date).then(async res => {
            loader('disable');

            // nav menu handler
            await navHandler(currentFilter, res);

            // y => weight
            // label => day, month, week
            // data => pie char helper
            drawBarChart(currentFilter, res.bar);

            drawPieChart(res.pie);
        });
    }, 100);
};

/**
 * Navigation Handler
 * Setup nav buttons and heading when new chart loaded.
 *
 * @param currentFilter
 * @param res
 */
const navHandler = function (currentFilter, res) {

    let header = $(`#bar-${currentFilter}-header`);

    // Set header text of pie chart
    header.data('start', res.header.start).data('end', res.header.end).text(res.header.text);

    // Set next and previous buttons
    let prevBtn = $(`#bar-${currentFilter}-prev-btn`);
    let nxtBtn = $(`#bar-${currentFilter}-next-btn`);
    prevBtn.data('date', res.header.prev);
    nxtBtn.data('date', res.header.next);

    let nxtDate = new Date(res.header.next);
    let curDate = new Date();

    // Hide next button if next date lies in future.
    curDate <= nxtDate ? nxtBtn.hide() : nxtBtn.show();
};

/**
 * Export chart of visible range
 */
$(document).on('click', '#export-chart-btn', function () {

    let currentFilter = activeFilter('#myTab');

    let header = $(`#bar-${currentFilter}-header`);

    let data = {
        filter: currentFilter,
        date: header.data('start'),
        ...getUsersData()
    };

    location.href = 'export-chart-data?' + $.param(data);
});

/**
 * Toggle enable / disable organization drop-down
 * Depending on user drop-down
 */
$(document).on("change", "#user_id", function () {
    $("#organization_id").attr("disabled", !!$("#user_id").val())
        .material_select();
});

/**
 * Draw chart again when any of the chart drop-down changed
 */
$(document).on("change", ".chart-dropdown", function () {
    drawCharts();
})
