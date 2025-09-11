@extends('master')


@section('content')
<section class="content-header">
  <h1>
    {{ ucfirst($moduleName) }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#" active>{{ ucfirst($moduleName) }}</a></li>
  </ol>
</section>
<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title"></h3>
      <div class="box-tools">
        <a href="{{ route('product.create') }}" class="btn btn-theme btn-sm">+ New {{ ucfirst($moduleName) }}</a>
      </div>
    </div>
    <div class="box-body">
      <table class="table table-bordered datatable">
        <thead>
          <tr>
            <th>Sr No.</th>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
          <tr>
            <th>Sr No.</th>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </tfoot>
      </table>
    </div>
    <div class="box-footer">
    </div>
  </div>
</section>
@endsection

@section('script')
<script>
  var table = $('.datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('getProductData') }}",
    columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex'
      },
      {
        data: 'name',
        name: 'name'
      },
      {
        data: 'is_active',
        name: 'is_active'
      },
      {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
      },
    ]
  });
</script>
@endsection