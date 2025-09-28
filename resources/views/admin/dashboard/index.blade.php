@extends('admin_master')
@section('content')
<div class="row row-cols-1 row-cols-xxl-4 row-cols-lg-4 row-cols-md-2 mt-2">
    <!-- <div class="col">
        <div class="card widget-icon-box">
            <div class="card-body card-body-dashboard">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="text-muted text-uppercase fs-13 mt-0" title="Number of Orders">Categories</h5>
                        <h3 class="my-1">{{ Helper::dashboard_count_data()['category_count'] }}</h3>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title text-bg-info rounded rounded-3 fs-3 widget-icon-box-avatar shadow">
                            <i class="ri-price-tag-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="col">
        <div class="card widget-icon-box">
            <div class="card-body card-body-dashboard">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="text-muted text-uppercase fs-13 mt-0" title="Average Revenue">Products</h5>
                        <h3 class="my-1">{{ Helper::dashboard_count_data()['product_count'] }}</h3>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title text-bg-danger rounded rounded-3 fs-3 widget-icon-box-avatar shadow">
                            <i class="ri-shopping-bag-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card widget-icon-box">
            <div class="card-body card-body-dashboard">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="text-muted text-uppercase fs-13 mt-0" title="Number of Customers">Customers</h5>
                        <h3 class="my-1">{{ Helper::dashboard_count_data()['customer_count'] }}</h3>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title text-bg-success rounded rounded-3 fs-3 widget-icon-box-avatar shadow">
                            <i class="ri-group-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card widget-icon-box">
            <div class="card-body card-body-dashboard">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="text-muted text-uppercase fs-13 mt-0" title="Growth">Invoices</h5>
                        <h3 class="my-1">{{ Helper::dashboard_count_data()['invoice_count'] }}</h3>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title text-bg-primary rounded rounded-3 fs-3 widget-icon-box-avatar shadow">
                            <i class="ri-file-text-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card widget-icon-box">
            <div class="card-body card-body-dashboard">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="text-muted text-uppercase fs-13 mt-0" title="Growth">Payment Received</h5>
                        <h3 class="my-1">{{ Helper::dashboard_count_data()['payment_received_count'] }}</h3>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title text-bg-primary rounded rounded-3 fs-3 widget-icon-box-avatar shadow">
                            <i class="ri-money-dollar-circle-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row row-cols-1 row-cols-xxl-2 row-cols-lg-2 row-cols-md-2">
    <div class="col">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Invoice Statistics</h5>
                        <div class="d-flex gap-2">
                            <select id="invoice_filter" class="form-select form-select-sm">
                                <option value="today">Today</option>
                                <option value="last7days" selected>Last 7 Days</option>
                                <option value="thismonth">This Month</option>
                                <option value="lastmonth">Last Month</option>
                                <option value="thisyear">This Year</option>
                                <option value="lastyear">Last Year</option>
                                <option value="custom">Custom Range</option>
                            </select>
                            <input type="text" id="invoice_date" class="form-control form-control-sm" style="display:none;" placeholder="Select Date Range">
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="invoiceChart" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Payment Statistics</h5>
                        <div class="d-flex gap-2">
                            <select id="payment_filter" class="form-select form-select-sm">
                                <option value="today">Today</option>
                                <option value="last7days" selected>Last 7 Days</option>
                                <option value="thismonth">This Month</option>
                                <option value="lastmonth">Last Month</option>
                                <option value="thisyear">This Year</option>
                                <option value="lastyear">Last Year</option>
                                <option value="custom">Custom Range</option>
                            </select>
                            <input type="text" id="payment_datetime" class="form-control form-control-sm" style="display:none;" placeholder="Select Date Range">
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="paymentChart" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Payment Method Distribution</h5>
                        <div class="d-flex gap-2">
                            <select id="payment_method_filter" class="form-select form-select-sm">
                                <option value="today">Today</option>
                                <option value="last7days" selected>Last 7 Days</option>
                                <option value="thismonth">This Month</option>
                                <option value="lastmonth">Last Month</option>
                                <option value="thisyear">This Year</option>
                                <option value="lastyear">Last Year</option>
                                <option value="custom">Custom Range</option>
                            </select>
                            <input type="text" id="payment_method_datetime" class="form-control form-control-sm" style="display:none;" placeholder="Select Date Range">
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="paymentMethodChart" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection

@section('script')
<!-- Apex Charts js -->
<script src="{{ asset('public/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<!-- Dashboard App js -->
<script src="{{ asset('public/assets/js/pages/dashboard.js') }}"></script>
<script src="{{ asset('public/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    $(document).ready(function() {
        let chart;
        let filter = $("#invoice_filter").val();
        let paymentChart;
        let paymentFilter = $("#payment_filter").val();

        // Flatpickr init
        $("#invoice_date").flatpickr({
            mode: "range",
            dateFormat: "Y-m-d",
            onClose: function(selectedDates, dateStr) {
                if (filter === "custom" && selectedDates.length === 2) {
                    loadInvoiceChart("custom", selectedDates[0].toISOString().split('T')[0], selectedDates[1].toISOString().split('T')[0]);
                }
            }
        });

        function loadInvoiceChart(range, start = null, end = null) {
            $.ajax({
                url: "{{ route('admin.invoice.chart') }}",
                data: {
                    range: range,
                    start_date: start,
                    end_date: end
                },
                success: function(res) {
                    if (chart) chart.destroy();

                    var options = {
                        series: [{
                                name: "Amount",
                                type: "line",
                                data: res.invoiceAmounts
                            },
                            {
                                name: "Invoices",
                                type: "bar",
                                data: res.invoiceCounts
                            }
                        ],
                        chart: {
                            height: 335,
                            type: "line",
                            offsetY: 0,
                            toolbar: {
                                show: false
                            }
                        },
                        stroke: {
                            width: [2, 1]
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: "25%"
                            }
                        },
                        colors: ["#4254ba", "#17a497", "#fa5c7c", "#ffbc00"],
                        dataLabels: {
                            enabled: !0,
                            enabledOnSeries: [1]
                        },
                        labels: res.labels,
                        xaxis: {
                            type: 'category',
                        },
                        tooltip: {
                            x: {
                                format: 'dd MMM yyyy' // tooltip shows full date
                            }
                        },
                        legend: {
                            offsetY: 7
                        },
                        grid: {
                            padding: {
                                bottom: 5
                            }
                        },
                        fill: {
                            type: "gradient",
                            gradient: {
                                shade: "light",
                                type: "horizontal",
                                shadeIntensity: .25,
                                gradientToColors: void 0,
                                inverseColors: !0,
                                opacityFrom: 0,
                                opacityTo: .75,
                                stops: [0, 0, 0]
                            }
                        },
                        yaxis: [{
                            title: {
                                text: "Invoice Amount"
                            }
                        }, {
                            opposite: !0,
                            title: {
                                text: "Number of Invoice"
                            }
                        }]
                    };

                    chart = new ApexCharts(document.querySelector("#invoiceChart"), options);
                    chart.render();
                }
            });
        }

        // Initial load
        loadInvoiceChart(filter);

        // Change filter
        $("#invoice_filter").on("change", function() {
            filter = $(this).val();
            if (filter === "custom") {
                $("#invoice_date").show();
            } else {
                $("#invoice_date").hide();
                loadInvoiceChart(filter);
            }
        });
        $("#payment_datetime").flatpickr({
            mode: "range",
            dateFormat: "Y-m-d",
            onClose: function(selectedDates, dateStr) {
                if (paymentFilter === "custom" && selectedDates.length === 2) {
                    loadPaymentChart("custom", selectedDates[0].toISOString().split('T')[0], selectedDates[1].toISOString().split('T')[0]);
                }
            }
        });

        function loadPaymentChart(range, start = null, end = null) {
            $.ajax({
                url: "{{ route('admin.payment.chart') }}",
                data: {
                    range: range,
                    start_date: start,
                    end_date: end
                },
                success: function(res) {
                    if (paymentChart) paymentChart.destroy();

                    var options = {
                        series: [{
                                name: "Amount",
                                type: "line",
                                data: res.paymentAmounts
                            },
                            {
                                name: "Payments",
                                type: "bar",
                                data: res.paymentCounts
                            }
                        ],
                        chart: {
                            height: 335,
                            type: "line",
                            offsetY: 0,
                            toolbar: {
                                show: false
                            }
                        },
                        stroke: {
                            width: [2, 1]
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: "25%"
                            }
                        },
                        colors: ["#4254ba", "#17a497", "#fa5c7c", "#ffbc00"],
                        dataLabels: {
                            enabled: true,
                            enabledOnSeries: [1]
                        },
                        labels: res.labels,
                        xaxis: {
                            type: 'category'
                        },
                        tooltip: {
                            x: {
                                format: 'dd MMM yyyy'
                            }
                        },
                        legend: {
                            offsetY: 7
                        },
                        grid: {
                            padding: {
                                bottom: 5
                            }
                        },
                        fill: {
                            type: "gradient",
                            gradient: {
                                shade: "light",
                                type: "horizontal",
                                shadeIntensity: .25,
                                inverseColors: true,
                                opacityFrom: 0,
                                opacityTo: .75,
                                stops: [0, 0, 0]
                            }
                        },
                        yaxis: [{
                            title: {
                                text: "Payment Amount"
                            }
                        }, {
                            opposite: true,
                            title: {
                                text: "Number of Payments"
                            }
                        }]
                    };

                    paymentChart = new ApexCharts(document.querySelector("#paymentChart"), options);
                    paymentChart.render();
                }
            });
        }

        // Initial load
        loadPaymentChart(paymentFilter);

        // Change filter
        $("#payment_filter").on("change", function() {
            paymentFilter = $(this).val();
            if (paymentFilter === "custom") {
                $("#payment_datetime").show();
            } else {
                $("#payment_datetime").hide();
                loadPaymentChart(paymentFilter);
            }
        });
        let paymentMethodChart;
        let paymentMethodFilter = $("#payment_method_filter").val();

        // Flatpickr for custom range
        $("#payment_method_datetime").flatpickr({
            mode: "range",
            dateFormat: "Y-m-d",
            onClose: function(selectedDates) {
                if (paymentMethodFilter === "custom" && selectedDates.length === 2) {
                    loadPaymentMethodChart("custom", selectedDates[0].toISOString().split('T')[0], selectedDates[1].toISOString().split('T')[0]);
                }
            }
        });

        function loadPaymentMethodChart(range, start = null, end = null) {
            $.ajax({
                url: "{{ route('admin.payment.method.chart') }}",
                data: {
                    range: range,
                    start_date: start,
                    end_date: end
                },
                success: function(res) {
                    if (paymentMethodChart) paymentMethodChart.destroy();
                    if (res.series.every(val => val === 0)) {
                        $("#paymentMethodChart").html('<div class="text-center text-muted mt-5">No data available</div>');
                    } else {
                        res.series = res.series.map(val => isNaN(val) ? 0 : val);
                        var options = {
                            series: res.series,
                            labels: res.labels,
                            chart: {
                                type: 'donut',
                                height: 350
                            },
                            noData: {
                                text: 'No payment data available',
                                align: 'center',
                                verticalAlign: 'middle',
                                style: {
                                    color: '#999',
                                    fontSize: '16px'
                                }
                            },
                            dataLabels: {
                                enabled: true,
                                formatter: function(val, opts) {
                                    return opts.w.config.series[opts.seriesIndex] + " (₹)";
                                }
                            },
                            legend: {
                                position: 'bottom'
                            },
                            tooltip: {
                                y: {
                                    formatter: function(val) {
                                        return "₹" + val;
                                    }
                                }
                            }
                        };
                        paymentMethodChart = new ApexCharts(document.querySelector("#paymentMethodChart"), options);
                        paymentMethodChart.render();
                    }
                }
            });
        }

        // Initial load
        loadPaymentMethodChart(paymentMethodFilter);

        // Filter change
        $("#payment_method_filter").on("change", function() {
            paymentMethodFilter = $(this).val();
            if (paymentMethodFilter === "custom") {
                $("#payment_method_datetime").show();
            } else {
                $("#payment_method_datetime").hide();
                loadPaymentMethodChart(paymentMethodFilter);
            }
        });

    });
</script>

@endsection