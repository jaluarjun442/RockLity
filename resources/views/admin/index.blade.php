@extends('admin_master')
@section('content')
<div class="row row-cols-1 row-cols-xxl-6 row-cols-lg-4 row-cols-md-2 mt-2">
    <div class="col">
        <div class="card widget-icon-box">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="text-muted text-uppercase fs-13 mt-0" title="Number of Orders">Categories</h5>
                        <h3 class="my-3">{{ Helper::dashboard_count_data()['category_count'] }}</h3>
                        <p class="mb-0 text-muted text-truncate">
                            <span class="badge bg-danger me-1"><i class="ri-arrow-down-line"></i> 1.08%</span>
                            <span>Since last month</span>
                        </p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title text-bg-info rounded rounded-3 fs-3 widget-icon-box-avatar shadow">
                            <i class="ri-price-tag-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card widget-icon-box">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="text-muted text-uppercase fs-13 mt-0" title="Average Revenue">Products</h5>
                        <h3 class="my-3">{{ Helper::dashboard_count_data()['product_count'] }}</h3>
                        <p class="mb-0 text-muted text-truncate">
                            <span class="badge bg-danger me-1"><i class="ri-arrow-down-line"></i> 7.00%</span>
                            <span>Since last month</span>
                        </p>
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
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="text-muted text-uppercase fs-13 mt-0" title="Number of Customers">Customers</h5>
                        <h3 class="my-3">{{ Helper::dashboard_count_data()['customer_count'] }}</h3>
                        <p class="mb-0 text-muted text-truncate">
                            <span class="badge bg-success me-1"><i class="ri-arrow-up-line"></i> 2,541</span>
                            <span>Since last month</span>
                        </p>
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
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="text-muted text-uppercase fs-13 mt-0" title="Growth">Invoices</h5>
                        <h3 class="my-3">{{ Helper::dashboard_count_data()['invoice_count'] }}</h3>
                        <p class="mb-0 text-muted text-truncate">
                            <span class="badge bg-success me-1"><i class="ri-arrow-up-line"></i> 4.87%</span>
                            <span>Since last month</span>
                        </p>
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
</div>

@endsection

@section('script')
<!-- Apex Charts js -->
<script src="{{ asset('public/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<!-- Dashboard App js -->
<script src="{{ asset('public/assets/js/pages/dashboard.js') }}"></script>
@endsection