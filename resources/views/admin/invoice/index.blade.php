@extends('admin_master')


@section('content')
<div class="row mt-2">
  <div class="col-12">
    <div class="card">
      <div class="card-body card-body-breadcums">
        <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
          <h4 class="page-title">{{ ucfirst($moduleName) }}</h4>
          <a href="{{ route('invoice.create') }}" class="btn btn-success mb-2">
            <i class="ri-add-line"></i> Add {{ ucfirst($moduleName) }}
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row mt-2">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <table id="datatable" class="table table-striped dt-responsive nowrap w-100">
          <thead>
            <tr>
              <th>Invoice Number</th>
              <th>Name</th>
              <th>Mobile</th>
              <th>Total</th>
              <th>Paid?</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
  var table = $('#datatable').DataTable({
    keys: !0,
    scrollX: true,
    "pagingType": "simple_numbers",
    language: {
      paginate: {
        previous: "<i class='ri-arrow-left-s-line'>",
        next: "<i class='ri-arrow-right-s-line'>"
      }
    },
    drawCallback: function() {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
    processing: true,
    serverSide: true,
    ajax: "{{ route('getInvoiceData') }}",
    columns: [{
        data: 'invoice_number',
        name: 'invoice_number'
      },
      {
        data: 'customer_name',
        name: 'customer_name'
      },
      {
        data: 'customer_mobile',
        name: 'customer_mobile'
      },
      {
        data: 'grand_total',
        name: 'grand_total'
      },
      {
        data: 'is_paid',
        name: 'is_paid'
      },
      {
        data: 'created_at',
        name: 'created_at'
      },
      {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false,
      },
    ]
  });
</script>
@endsection