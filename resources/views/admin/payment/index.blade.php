@extends('admin_master')


@section('content')
<div class="row mt-2">
  <div class="col-12">
    <div class="card">
      <div class="card-body card-body-breadcums">
        <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
          <h4 class="page-title">{{ ucfirst($moduleName) }}</h4>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Filters Row -->
<div class="row mt-2 align-items-end">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row g-2">
          <div class="col-md-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select class="form-select" id="customer_id" name="customer_id"></select>
          </div>
          <div class="col-md-2">
            <label for="mobile" class="form-label">Mobile</label>
            <input type="text" id="mobile" class="form-control" placeholder="Enter mobile">
          </div>
          <div class="mb-1 col-md-3">
            <label for="payment_datetime" class="form-label">Payment Date</label>
            <input type="text" class="form-control" id="payment_datetime" name="payment_datetime" placeholder="Select date range" value="">
          </div>
          <div class="col-md-1">
            <label for="filter_payment_method" class="form-label">Method</label>
            <select class="form-select" id="filter_payment_method">
              <option value="">All</option>
              @foreach(\App\Enums\PaymentMethod::values() as $type)
              <option value="{{ $type }}">{{ $type }}</option>
              @endforeach
            </select>
          </div>
          <div style="margin-top: 2.35rem;" class="mb-1 col-md-2">
            <button type="button" id="filterBtn" class="btn btn-primary btn-sm">Filter</button>
            <button type="button" id="clearFilterBtn" class="btn btn-secondary btn-sm">Clear</button>

          </div>

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
              <th>Customer</th>
              <th>Mobile</th>
              <th>Amount</th>
              <th>Payment Method</th>
              <th>Time</th>
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
<div class="modal fade" id="editPaymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="updatePaymentForm">
          @csrf
          <input type="hidden" name="payment_id" id="payment_id">

          <div class="row g-3">
            <div class="col-md-3">
              <label>Amount</label>
              <input type="number" name="amount" id="amount" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label>Payment Method</label>
              <select name="payment_method" id="payment_method" class="form-control" required>
                @foreach(\App\Enums\PaymentMethod::values() as $type)
                <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label>Remarks</label>
              <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Enter remarks (optional)">
            </div>
          </div>

          <div class="mt-3">
            <button type="submit" class="btn btn-success">Update Payment</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script>
  $(document).on('click', '.edit-payment-btn', function() {
    var paymentId = $(this).data('id');

    // Use named route
    var url = '{{ route("payment.edit", ":id") }}';
    url = url.replace(':id', paymentId);

    $.ajax({
      url: url,
      type: 'GET',
      success: function(res) {
        // Fill form fields
        $('#payment_id').val(res.id);
        $('#amount').val(res.amount);
        $('#payment_method').val(res.payment_method);
        $('#remarks').val(res.remarks);

        // Show modal
        $('#editPaymentModal').modal('show');
      }
    });
  });

  $('#updatePaymentForm').on('submit', function(e) {
    e.preventDefault();

    var paymentId = $('#payment_id').val();
    var url = '{{ route("payment.update", ":id") }}';
    url = url.replace(':id', paymentId);

    $.ajax({
      url: url,
      type: 'POST',
      data: $(this).serialize(),
      success: function(res) {
        if (res.success) {
          $('#editPaymentModal').modal('hide');
          $('#datatable').DataTable().ajax.reload(null, false); // reload table
          $.toast({
            heading: 'Success',
            text: "Payment updated successfully",
            showHideTransition: 'slide',
            icon: 'success',
            position: 'top-center',
            loaderBg: '#159488',
            hideAfter: 3000
          });
        }
      }
    });
  });

  $("#payment_datetime").flatpickr({
    mode: "range",
    dateFormat: "Y-m-d",
    // maxDate: "today",
    allowInput: true
  });

  // Select2 for Customer
  $('#customer_id').select2({
    placeholder: 'Search customer',
    ajax: {
      url: '{{ route("invoice.get_customers_ajax_data") }}',
      dataType: 'json',
      delay: 250,
      data: function(params) {
        return {
          search: params.term
        };
      },
      processResults: function(data) {
        return {
          results: $.map(data, function(item) {
            let text = item.name;
            if (item.mobile && item.mobile.trim() !== '') {
              text += ' - ' + item.mobile;
            }
            return {
              id: item.id,
              text: text
            };
          })
        };
      },
      cache: true
    }
  });
  // Initialize Datatable
  var table = $('#datatable').DataTable({
    keys: true,
    scrollX: true,
    pagingType: "simple_numbers",
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
    ajax: {
      url: "{{ route('getInvoicePaymentData') }}",
      data: function(d) {
        d.payment_datetime = $('#payment_datetime').val();
        d.mobile = $('#mobile').val();
        d.customer_id = $('#customer_id').val();
        d.is_paid = $('#is_paid').val();
        d.payment_method = $('#filter_payment_method').val();
      }
    },
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
        data: 'amount',
        name: 'amount'
      },
      {
        data: 'payment_method',
        name: 'payment_method'
      },
      {
        data: 'payment_datetime',
        name: 'payment_datetime'
      },
      {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
      }
    ]
  });

  // Filter button click
  $('#filterBtn').on('click', function() {
    table.draw();
  });

  // Clear filter button click
  $('#clearFilterBtn').on('click', function() {
    $('#payment_datetime').val('');
    $('#mobile').val('');
    $('#customer_id').val(null).trigger('change');
    $('#is_paid').val('');

    $('#payment_method').val('');
    table.draw();
  });
</script>
@endsection