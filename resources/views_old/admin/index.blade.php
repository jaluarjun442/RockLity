@extends('master')


@section('content')
<section class="content-header">
    <h1>
        Dashboard
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box">
                <div class="inner">
                    <h3>{{ Helper::dashboard_count_data()['category_count'] }}</h3>
                    <p>Categories</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tags" aria-hidden="true"></i>
                </div>
                <a href="{{ url('admin/category') }}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box">
                <div class="inner">
                    <h3>{{ Helper::dashboard_count_data()['product_count'] }}</h3>
                    <p>Products</p>
                </div>
                <div class="icon">
                    <i class="fa fa-cubes" aria-hidden="true"></i>
                </div>
                <a href="{{ url('admin/category') }}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box">
                <div class="inner">
                    <h3>{{ Helper::dashboard_count_data()['customer_count'] }}</h3>
                    <p>Customers</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users" aria-hidden="true"></i>
                </div>
                <a href="{{ url('admin/category') }}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box">
                <div class="inner">
                    <h3>{{ Helper::dashboard_count_data()['invoice_count'] }}</h3>
                    <p>Invoices</p>
                </div>
                <div class="icon">
                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                </div>
                <a href="{{ url('admin/category') }}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
@endsection