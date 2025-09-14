@extends('admin_master')


@section('content')
<div class="row mt-2">
  <div class="col-12">
    <div class="card">
      <div class="card-body card-body-breadcums">
        <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
          <h4 class="page-title">{{ ucfirst($moduleName) }}</h4>
          <a href="{{ route('product.create') }}" class="btn btn-success mb-2">
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
              <!-- <th>Id</th> -->
              <!-- <th>Image</th> -->
              <th>Sku</th>
              <th>Name</th>
              <th>Price</th>
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
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h6 class="modal-title" id="imageModalLabel">Product Image</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-2">
        <img id="modalImage" src="" class="img-fluid rounded shadow-sm" alt="Product Image" style="max-height:250px;">
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
    ajax: "{{ route('getProductData') }}",
    columns: [
      // {
      //   data: 'id',
      //   name: 'id'
      // },
      // {
      //   data: 'image',
      //   name: 'image'
      // },
      {
        data: 'sku',
        name: 'sku'
      },
      {
        data: 'name',
        name: 'name'
      },
      {
        data: 'price',
        name: 'price'
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
  $(document).on('click', '.view-image-btn', function() {
    let imageUrl = $(this).data('image_url');
    $('#modalImage').attr('src', imageUrl);
    $('#imageModal').modal('show');
  });
</script>
@endsection