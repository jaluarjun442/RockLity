@extends('admin_master')

@section('content')
<div class="row mt-2">
  <div class="col-12">
    <div class="card">
      <div class="card-body card-body-breadcums">
        <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
          <h4 class="page-title">Add {{ ucfirst($moduleName) }}</h4>
          <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('invoice') }}">{{ ucfirst($moduleName) }}</a></li>
            <li class="breadcrumb-item active">Add {{ ucfirst($moduleName) }}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('invoice.store') }}" method="POST" id="invoiceForm">
          @csrf
          <div class="row g-2">
            <!-- Select Customer -->
            <div class="mb-1 col-md-4">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="customer_id" class="form-label">Customer</label>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addCustomerModal" class="btn btn-sm btn-outline-primary">+ Add Customer</a>
              </div>
              <select class="form-select" id="customer_id" name="customer_id" required>
                @if(Helper::settings()->default_customer)
                <option value="{{ Helper::settings()->default_customer->id }}">{{ Helper::settings()->default_customer->name ?? '' }} {{ Helper::settings()->default_customer->mobile ? '-'.Helper::settings()->default_customer->mobile : '' }}</option>
                @endif
              </select>
              <span class="error text-danger">{{ $errors->first('customer_id') }}</span>
            </div>

            <div class="mb-1 col-md-5">
            </div>
            <!-- Invoice Date -->
            <div class="mb-1 col-md-3">
              <label for="invoice_date" class="form-label">Invoice Date</label>
              <input type="text" class="form-control" id="invoice_date" name="invoice_date" value="{{ date('Y-m-d') }}">
              <span class="error text-danger">{{ $errors->first('invoice_date') }}</span>
            </div>

            <!-- Products Table -->
            <div class="col-12">
              <label class="form-label">Products</label>
              <table class="table table-bordered" id="productsTable">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th><button type="button" class="btn btn-success btn-sm" id="addRow">+</button></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="width: 60%;">
                      <select name="product_id[]" class="form-control product_select select2" required></select>
                    </td>
                    <td><input type="number" name="quantity[]" class="form-control quantity" value="1" min="1" required></td>
                    <td><input type="text" name="price[]" class="form-control price"></td>
                    <td><input type="text" name="total[]" class="form-control total"></td>
                    <td><button type="button" class="btn btn-danger btn-sm removeRow">-</button></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Subtotal, Discount, Total -->
            <div class="col-md-8">
            </div>
            <div class="col-md-4">
              <div class="input-group mb-2">
                <span class="input-group-text" style="width: 100px;">Sub Total</span>
                <input type="text" class="form-control" id="sub_total" name="sub_total" readonly>
              </div>

              <div class="input-group mb-2">
                <span class="input-group-text" style="width: 100px;">Discount</span>
                <input type="number" min="0" class="form-control" id="total_discount" name="total_discount" value="0">
              </div>

              <div class="input-group mb-2">
                <span class="input-group-text" style="width: 100px;">Tax/Charge</span>
                <input type="number" min="0" class="form-control" id="total_charge" name="total_charge" value="0">
              </div>

              <div class="input-group mb-2">
                <span class="input-group-text" style="width: 100px;">Grand Total</span>
                <input type="text" class="form-control" id="grand_total" name="grand_total" readonly>
              </div>
            </div>




            <!-- <div class="col-md-4">
            </div>
            <div class="col-md-4">
            </div> -->

            <!-- Payment -->
            <div class="col-md-8">
            </div>
            <div class="col-md-2">
              <label for="is_paid" class="form-label">Payment Received?</label>
              <select name="is_paid" id="is_paid" class="form-select">
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>

            <div class="col-md-2 ">
              <div class="payment_method_div">

                <label for="payment_amount" class="form-label">Payment Amount</label>
                <input type="text" class="form-control" id="payment_amount" name="payment_amount" value="0">

                <label for="payment_method" class="form-label">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-select">
                  @foreach(\App\Enums\PaymentMethod::values() as $type)
                  <option value="{{ $type }}">{{ $type }}</option>
                  @endforeach
                </select>

              </div>
              <div class="mb-1 d-none payment_due_date_div">
                <label for="due_amount" class="form-label">Due Amount</label>
                <input type="text" class="form-control" id="due_amount" name="due_amount" value="0">
                <span class="error text-danger">{{ $errors->first('due_amount') }}</span>
                <label for="due_date" class="form-label">Due Date</label>
                <input type="text" class="form-control" id="due_date" name="due_date" value="{{ date('Y-m-d') }}">
                <span class="error text-danger">{{ $errors->first('due_date') }}</span>
              </div>
            </div>
            <!-- Description -->
            <!-- <div class="col-md-12">
              <label for="description" class="form-label">Description</label>
              <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') }}</textarea>
            </div> -->

          </div>
          <hr>
          <button type="submit" class="btn btn-primary mt-3"><i class="ri-add-line"></i> Add Invoice</button>
          <a href="{{ route('invoice') }}" class="btn btn-secondary mt-3"><i class="ri-close-line"></i> Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="quickAddCustomerForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addCustomerModalLabel">Quick Add Customer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-2">
            <div class="mb-1 col-md-4">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-1 col-md-4">
              <label for="mobile" class="form-label">Mobile</label>
              <input type="text" class="form-control" name="mobile">
            </div>
            <div class="mb-1 col-md-4">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email">
            </div>
            <div class="mb-1 col-md-4">
              <label for="gst" class="form-label">GST</label>
              <input type="text" class="form-control" name="gst">
            </div>
            <div class="mb-1 col-md-4">
              <label for="pan" class="form-label">PAN</label>
              <input type="text" class="form-control" name="pan">
            </div>
            <div class="mb-1 col-md-4">
              <label for="is_active" class="form-label">Status</label>
              <select name="is_active" class="form-select">
                <option value="1" selected>Active</option>
                <option value="0">Inactive</option>
              </select>
            </div>
            <div class="mb-1 col-md-12">
              <label for="address" class="form-label">Address</label>
              <textarea name="address" rows="2" class="form-control"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Add Customer</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
@section('script')
<script>
  $(document).ready(function() {
    $("#invoice_date").flatpickr();
    $("#due_date").flatpickr();
    // Initialize Customer Select2 AJAX
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

    // Initialize Product Select2 AJAX for each product select
    function initProductSelect(element) {
      element.select2({
        placeholder: 'Search product',
        ajax: {
          url: '{{ route("invoice.get_products_ajax_data") }}',
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
                return {
                  id: item.id,
                  text: item.name + ' (' + item.price + ')',
                  price: parseFloat(item.price) || 0
                };
              })
            };
          },
          cache: true
        }
      }).on('select2:select', function(e) {
        var price = parseFloat(e.params.data.price) || 0;
        var row = $(this).closest('tr');
        row.find('.price').val(price.toFixed(2));
        row.find('.quantity').val(1);
        row.find('.total').val(price.toFixed(2));
        calculateTotals();
      });
    }

    // Initialize first row
    $('#productsTable tbody tr').each(function() {
      initProductSelect($(this).find('.product_select'));
    });

    $('#addRow').click(function() {
      // Create a new row HTML manually instead of cloning the existing row
      var newRow = `
      <tr>
        <td style="width: 60%;">
          <select name="product_id[]" class="form-control product_select select2" required></select>
        </td>
        <td><input type="number" name="quantity[]" class="form-control quantity" value="1" min="1" required></td>
        <td><input type="text" name="price[]" class="form-control price" ></td>
        <td><input type="text" name="total[]" class="form-control total" ></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow">-</button></td>
      </tr>
    `;

      // Append the new row
      $('#productsTable tbody').append(newRow);

      // Initialize Select2 on the new row only
      initProductSelect($('#productsTable tbody tr:last').find('.product_select'));
    });
    $(document).on('input', '#total_discount, #total_charge, .total, .quantity, .price', function() {
      let val = $(this).val();
      val = val.replace(/[^0-9.]/g, ''); // remove invalid chars

      // allow empty while typing
      if (val === '' || isNaN(parseFloat(val))) {
        $(this).val('');
      } else {
        if ($(this).hasClass('quantity')) {
          $(this).val(parseFloat(val));
        } else {
          $(this).val(val); // keep raw input, format later on blur
        }
      }

      calculateTotals();
    });

    // Format on blur
    $(document).on('blur', '#total_discount, #total_charge, .total, .price', function() {
      let val = $(this).val();
      if (val !== '' && !isNaN(parseFloat(val))) {
        $(this).val(parseFloat(val).toFixed(2));
      }
    });

    $(document).on('blur', '.quantity', function() {
      let val = $(this).val();
      if (val !== '' && !isNaN(parseFloat(val))) {
        $(this).val(parseFloat(val));
      }
    });

    // Remove product row
    $('#productsTable').on('click', '.removeRow', function() {
      if ($('#productsTable tbody tr').length > 1) {
        $(this).closest('tr').remove();
        calculateTotals();
      }
    });

    // Calculate totals on quantity or price change
    $('#productsTable').on('input', '.quantity, .price', function() {
      var row = $(this).closest('tr');
      var qty = parseFloat(row.find('.quantity').val()) || 0;
      var price = parseFloat(row.find('.price').val()) || 0;
      row.find('.total').val((qty * price).toFixed(2));
      calculateTotals();
    });

    $(document).on('input', '#total_discount, #total_charge, .total', function() {
      calculateTotals();
    });

    // Calculate subtotal and grand total
    function calculateTotals() {
      var subTotal = 0;
      $('#productsTable tbody tr').each(function() {
        var row = $(this).closest('tr');
        var total = parseFloat(row.find('.total').val()) || 0;
        subTotal += total;
      });
      $('#sub_total').val(subTotal.toFixed(2));

      var discount = parseFloat($('#total_discount').val()) || 0;
      var tax_charge = parseFloat($('#total_charge').val()) || 0;
      $('#grand_total').val((subTotal - discount + tax_charge).toFixed(2));
      $('#payment_amount').val((subTotal - discount + tax_charge).toFixed(2)).trigger('input');
    }
    $(document).on('input change', '#payment_amount', function() {
      $('#due_amount').val((parseFloat($('#grand_total').val()) - parseFloat($('#payment_amount').val())).toFixed(2)).trigger('input');
      togglePaymentFields();
    });

    function togglePaymentFields() {
      let isPaid = $("#is_paid").val();
      if (isPaid == "1") {
        $(".payment_method_div").removeClass("d-none");
        if ($('#due_amount').val() > 0) {
          $(".payment_due_date_div").removeClass("d-none");
        } else {
          $(".payment_due_date_div").addClass("d-none");
        }
        let today = new Date().toISOString().split("T")[0];
        $("#due_date").val(today);
      } else if (isPaid == "0") {
        $('#payment_amount').val(0);
        $('#due_amount').val((parseFloat($('#grand_total').val()) - parseFloat($('#payment_amount').val())).toFixed(2)).trigger('input');
        $(".payment_method_div").addClass("d-none");
        $(".payment_due_date_div").removeClass("d-none");
        $("#payment_method").val("Cash");
      }

    }
    $('#quickAddCustomerForm').on('submit', function(e) {
      e.preventDefault();
      const formData = $(this).serialize();
      $.ajax({
        url: '{{ route("customer.store_popup") }}',
        method: 'POST',
        data: formData,
        success: function(response) {
          if (response.success) {
            $('#addCustomerModal').modal('hide');
            $('#quickAddCustomerForm')[0].reset();
            const newOption = new Option(response.customer.name + ' - ' + (response.customer.mobile || ''), response.customer.id, true, true);
            $('#customer_id').append(newOption).trigger('change');
          } else {
            alert(response.message || 'Failed to add customer');
          }
        },
        error: function(xhr) {
          let msg = 'Something went wrong.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            msg = xhr.responseJSON.message;
          }
          alert(msg);
        }
      });
    });
    $("#is_paid").on("change", function() {
      togglePaymentFields();
    });
    togglePaymentFields();
  });
</script>
@endsection