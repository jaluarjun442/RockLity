@extends('admin_master')

@section('content')
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-body card-body-breadcums">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Edit {{ ucfirst($moduleName) }}</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('invoice') }}">{{ ucfirst($moduleName) }}</a></li>
                        <li class="breadcrumb-item active">Edit {{ ucfirst($moduleName) }}</li>
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
                <form action="{{ route('invoice.update', $invoice->id) }}" method="POST" id="invoiceForm">
                    @csrf
                    @method('PUT')
                    <div class="row g-2">

                        <!-- Customer -->
                        <div class="mb-1 col-md-6">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select class="form-select" id="customer_id" name="customer_id" required>
                                <option value="{{ $invoice->customer_id }}" selected>
                                    {{ $invoice->customer->name ?? '' }} - {{ $invoice->customer->mobile ?? '' }}
                                </option>
                            </select>
                            <span class="error text-danger">{{ $errors->first('customer_id') }}</span>
                        </div>

                        <div class="mb-1 col-md-3"></div>

                        <!-- Invoice Date -->
                        <div class="mb-1 col-md-3">
                            <label for="invoice_date" class="form-label">Invoice Date</label>
                            <input type="text" class="form-control" id="invoice_date"
                                name="invoice_date" value="{{ $invoice->invoice_date }}">
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
                                    @foreach($invoice->invoice_product as $product)
                                    <tr>
                                        <td style="width: 60%;">
                                            <select name="product_id[]" class="form-control product_select select2" required>
                                                <option value="{{ $product->product_id }}" selected>
                                                    {{ $product->product_name ?? 'Product '.$product->product_id }}
                                                </option>
                                            </select>
                                        </td>
                                        <td><input type="number" name="quantity[]" class="form-control quantity"
                                                value="{{ $product->quantity }}" min="1" required></td>
                                        <td><input type="text" name="price[]" class="form-control price"
                                                value="{{ number_format($product->price,2) }}"></td>
                                        <td><input type="text" name="total[]" class="form-control total"
                                                value="{{ number_format($product->total,2) }}"></td>
                                        <td><button type="button" class="btn btn-danger btn-sm removeRow">-</button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Totals -->
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="input-group mb-2">
                                <span class="input-group-text" style="width: 100px;">Sub Total</span>
                                <input type="text" class="form-control" id="sub_total" name="sub_total"
                                    value="{{ number_format($invoice->sub_total,2) }}" readonly>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text" style="width: 100px;">Discount</span>
                                <input type="number" min="0" class="form-control" id="total_discount" name="total_discount"
                                    value="{{ $invoice->total_discount }}">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text" style="width: 100px;">Tax/Charge</span>
                                <input type="number" min="0" class="form-control" id="total_charge" name="total_charge"
                                    value="{{ $invoice->total_charge }}">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text" style="width: 100px;">Grand Total</span>
                                <input type="text" class="form-control" id="grand_total" name="grand_total"
                                    value="{{ number_format($invoice->grand_total,2) }}" readonly>
                            </div>
                        </div>

                        <!-- Payment -->
                        <div class="col-md-4">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-select">
                                <select name="payment_method" id="payment_method" class="form-select">
                                    @foreach(\App\Enums\PaymentMethod::values() as $type)
                                    <option value="{{ $type }}" {{ $invoice->payment_method === $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                    @endforeach
                                </select>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="is_paid" class="form-label">Paid</label>
                            <select name="is_paid" id="is_paid" class="form-select">
                                <option value="1" {{ $invoice->is_paid ? 'selected':'' }}>Yes</option>
                                <option value="0" {{ !$invoice->is_paid ? 'selected':'' }}>No</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary mt-3"><i class="ri-save-line"></i> Update Invoice</button>
                    <a href="{{ route('invoice') }}" class="btn btn-secondary mt-3"><i class="ri-close-line"></i> Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $("#invoice_date").flatpickr();
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
                            return {
                                id: item.id,
                                text: item.name + ' - ' + item.mobile
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
        }


    });
</script>
@endsection