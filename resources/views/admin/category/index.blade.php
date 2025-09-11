@extends('admin_master')


@section('content')
<div class="row mt-2">
  <div class="col-12">
    <div class="card">
      <div class="card-body card-body-breadcums">
        <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
          <h4 class="page-title">{{ ucfirst($moduleName) }}</h4>
          <a href="{{ route('category.create') }}" class="btn btn-success mb-2">
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
              <th>Id</th>
              <th>Image</th>
              <th>Name</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
          <!-- <tfoot>
            <tr>
              <th>Sr No.</th>
              <th>Image</th>
              <th>Name</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </tfoot> -->
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
    ajax: "{{ route('getCategoryData') }}",
    columns: [{
        data: 'id',
        name: 'id'
      },
      {
        data: 'image',
        name: 'image'
      },
      {
        data: 'name',
        name: 'name'
      },
      {
        data: 'status',
        name: 'status'
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