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
          <div class="mb-1 col-md-2">
            <label for="invoice_date" class="form-label">Invoice Date</label>
            <input type="text" class="form-control" id="invoice_date" name="invoice_date" placeholder="Select date range" value="">
          </div>
          <div class="mb-1 col-md-2">
            <label for="invoice_date" class="form-label">Due Date</label>
            <input type="text" class="form-control" id="due_date" name="due_date" placeholder="Select date" value="">
          </div>
          <div class="col-md-1">
            <label for="is_paid" class="form-label">Paid?</label>
            <select class="form-select" id="is_paid">
              <option value="">All</option>
              <option value="1">Yes</option>
              <option value="0">No</option>
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
              <th>Total</th>
              <th>Paid?</th>
              <th>Date</th>
              <th>Due Date</th>
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
<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel">Invoice Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="paymentFormContainer">
          <div class="text-center">Loading...</div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script>
  $(document).on('click', '.view-payment', function() {
    let invoiceId = $(this).data('id');

    $('#paymentFormContainer').html('<div class="text-center">Loading...</div>');
    $('#paymentModal').modal('show');

    $.ajax({
      url: '{{ route("invoice.get_payment_ajax_data") }}',
      type: 'GET',
      data: {
        invoice_id: invoiceId
      },
      success: function(res) {
        $('#paymentFormContainer').html(res);
      },
      error: function() {
        $('#paymentFormContainer').html('<div class="text-danger text-center">Failed to load form.</div>');
      }
    });
  });

  // Submit payment via AJAX
  $(document).on('submit', '#updatePaymentForm', function(e) {
    e.preventDefault();
    let form = $(this);
    let invoiceId = form.find('input[name="invoice_id"]').val();

    $.ajax({
      url: '{{ route("invoice.add_payment") }}',
      type: 'POST',
      data: form.serialize(),
      success: function(res) {
        $.toast({
          heading: 'Success',
          text: "Payment added successfully",
          showHideTransition: 'slide',
          icon: 'success',
          position: 'top-center',
          loaderBg: '#159488',
          hideAfter: 3000
        });
        $('#paymentModal').modal('hide');
        $('#datatable').DataTable().ajax.reload(null, false);
      },
      error: function(err) {
        $.toast({
          heading: 'Error',
          text: "Failed to Add Payment",
          showHideTransition: 'slide',
          icon: 'error',
          position: 'top-center',
          loaderBg: '#de4034',
          hideAfter: 3000
        });
      }
    });
  });
  $("#invoice_date").flatpickr({
    mode: "range",
    dateFormat: "Y-m-d",
    // maxDate: "today",
    allowInput: true
  });
  $("#due_date").flatpickr({
    // mode: "range",
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
      url: "{{ route('getInvoiceData') }}",
      data: function(d) {
        d.invoice_date = $('#invoice_date').val();
        d.due_date = $('#due_date').val();
        d.mobile = $('#mobile').val();
        d.customer_id = $('#customer_id').val();
        d.is_paid = $('#is_paid').val();
        d.payment_method = $('#payment_method').val();
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
        data: 'grand_total',
        name: 'grand_total'
      },
      {
        data: 'is_paid',
        name: 'is_paid'
      },
      {
        data: 'invoice_date',
        name: 'invoice_date'
      },
      {
        data: 'due_date',
        name: 'due_date'
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
    $('#invoice_date').val('');
    $('#due_date').val('');
    $('#mobile').val('');
    $('#customer_id').val(null).trigger('change');
    $('#is_paid').val('');
    $('#payment_method').val('');
    table.draw();
  });
</script>
@endsection