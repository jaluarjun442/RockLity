@extends('admin_master')

@section('content')
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-body card-body-breadcums">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">{{ ucfirst($moduleName) }}</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ ucfirst($moduleName) }}</li>
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
                <form action="{{ route('admin.setting.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf()
                    @method('PUT')
                    <div class="row g-2">
                        <div class="mb-1 col-md-4">
                            <label for="name" class="form-label">Name</label>
                            <input value="{{ old('name',$setting->name) }}" type="text" class="form-control" id="name" name="name" placeholder="Name">
                            <span class="error text-danger"> {{ $errors->first('name') }}</span>
                        </div>
                        <div class="mb-1 col-md-4">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input value="{{ old('mobile',$setting->mobile) }}" type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile">
                            <span class="error text-danger"> {{ $errors->first('mobile') }}</span>
                        </div>
                        <div class="mb-1 col-md-4">
                            <label for="email" class="form-label">Email</label>
                            <input value="{{ old('email',$setting->email) }}" type="text" class="form-control" id="email" name="email" placeholder="Email">
                            <span class="error text-danger"> {{ $errors->first('email') }}</span>
                        </div>
                        <div class="mb-1 col-md-4">
                            <label for="tagline" class="form-label">Tagline</label>
                            <input value="{{ old('tagline',$setting->tagline) }}" type="text" class="form-control" id="tagline" name="tagline" placeholder="Tagline">
                            <span class="error text-danger"> {{ $errors->first('tagline') }}</span>
                        </div>
                        <div class="mb-1 col-md-4">
                            <div class="d-flex align-items-center">
                                <label for="logo" class="form-label mb-0">Logo</label>
                                @if(!empty($setting->logo))
                                <button type="button"
                                    class="btn btn-outline-secondary d-flex align-items-center gap-1 py-0 px-2"
                                    style="font-size: 0.7rem; height: 28px; margin-left: 5px;"
                                    data-bs-toggle="modal" data-bs-target="#logoModal">
                                    <i class="ri-eye-line"></i> View
                                </button>
                                @endif
                            </div>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                            <span class="error text-danger">{{ $errors->first('logo') }}</span>
                        </div>
                        @if(!empty($setting->logo))
                        <div class="modal fade" id="logoModal" tabindex="-1" aria-labelledby="logoModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="logoModalLabel">Logo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('public/uploads/setting/' . $setting->logo) }}" alt="Logo" class="img-fluid rounded shadow">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="mb-1 col-md-4">
                            <div class="d-flex align-items-center">
                                <label for="favicon" class="form-label mb-0">Favicon</label>
                                @if(!empty($setting->favicon))
                                <button type="button"
                                    class="btn btn-outline-secondary d-flex align-items-center gap-1 py-0 px-2"
                                    style="font-size: 0.7rem; height: 28px; margin-left: 5px;"
                                    data-bs-toggle="modal" data-bs-target="#faviconModal">
                                    <i class="ri-eye-line"></i> View
                                </button>
                                @endif
                            </div>
                            <input type="file" class="form-control" id="favicon" name="favicon" accept="image/*">
                            <span class="error text-danger">{{ $errors->first('favicon') }}</span>
                        </div>
                        @if(!empty($setting->favicon))
                        <div class="modal fade" id="faviconModal" tabindex="-1" aria-labelledby="faviconModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="faviconModalLabel">Favicon</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('public/uploads/setting/' . $setting->favicon) }}" alt="favicon" class="img-fluid rounded shadow">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <hr>
                        <h5 class=" mb-1 fs-16">Address Details</h5>
                        <div class="mb-1 col-md-4">
                            <label for="address_line_1" class="form-label">Address Line 1</label>
                            <input value="{{ old('address_line_1',$setting->address_line_1) }}" type="text" class="form-control" id="address_line_1" name="address_line_1" placeholder="Address Line 1">
                            <span class="error text-danger"> {{ $errors->first('address_line_1') }}</span>
                        </div>
                        <div class="mb-1 col-md-4">
                            <label for="address_line_2" class="form-label">Address Line 2</label>
                            <input value="{{ old('address_line_2',$setting->address_line_2) }}" type="text" class="form-control" id="address_line_2" name="address_line_2" placeholder="Address Line 2">
                            <span class="error text-danger"> {{ $errors->first('address_line_2') }}</span>
                        </div>
                        <div class="mb-1 col-md-4">
                            <label for="city" class="form-label">City</label>
                            <input value="{{ old('city',$setting->city) }}" type="text" class="form-control" id="city" name="city" placeholder="City">
                            <span class="error text-danger"> {{ $errors->first('city') }}</span>
                        </div>
                        <div class="mb-1 col-md-4">
                            <label for="state" class="form-label">State</label>
                            <select id="state" name="state" class="form-select">
                                <option value="">-- Select State --</option>
                                <option value="Andaman and Nicobar Islands" <?php if ($setting->state == "Andaman and Nicobar Islands") echo "selected"; ?>>Andaman and Nicobar Islands</option>
                                <option value="Andhra Pradesh" <?php if ($setting->state == "Andhra Pradesh") echo "selected"; ?>>Andhra Pradesh</option>
                                <option value="Arunachal Pradesh" <?php if ($setting->state == "Arunachal Pradesh") echo "selected"; ?>>Arunachal Pradesh</option>
                                <option value="Assam" <?php if ($setting->state == "Assam") echo "selected"; ?>>Assam</option>
                                <option value="Bihar" <?php if ($setting->state == "Bihar") echo "selected"; ?>>Bihar</option>
                                <option value="Chandigarh" <?php if ($setting->state == "Chandigarh") echo "selected"; ?>>Chandigarh</option>
                                <option value="Chhattisgarh" <?php if ($setting->state == "Chhattisgarh") echo "selected"; ?>>Chhattisgarh</option>
                                <option value="Dadra and Nagar Haveli and Daman and Diu" <?php if ($setting->state == "Dadra and Nagar Haveli and Daman and Diu") echo "selected"; ?>>Dadra and Nagar Haveli and Daman and Diu</option>
                                <option value="Delhi" <?php if ($setting->state == "Delhi") echo "selected"; ?>>Delhi</option>
                                <option value="Goa" <?php if ($setting->state == "Goa") echo "selected"; ?>>Goa</option>
                                <option value="Gujarat" <?php if ($setting->state == "Gujarat") echo "selected"; ?>>Gujarat</option>
                                <option value="Haryana" <?php if ($setting->state == "Haryana") echo "selected"; ?>>Haryana</option>
                                <option value="Himachal Pradesh" <?php if ($setting->state == "Himachal Pradesh") echo "selected"; ?>>Himachal Pradesh</option>
                                <option value="Jammu and Kashmir" <?php if ($setting->state == "Jammu and Kashmir") echo "selected"; ?>>Jammu and Kashmir</option>
                                <option value="Jharkhand" <?php if ($setting->state == "Jharkhand") echo "selected"; ?>>Jharkhand</option>
                                <option value="Karnataka" <?php if ($setting->state == "Karnataka") echo "selected"; ?>>Karnataka</option>
                                <option value="Kerala" <?php if ($setting->state == "Kerala") echo "selected"; ?>>Kerala</option>
                                <option value="Ladakh" <?php if ($setting->state == "Ladakh") echo "selected"; ?>>Ladakh</option>
                                <option value="Lakshadweep" <?php if ($setting->state == "Lakshadweep") echo "selected"; ?>>Lakshadweep</option>
                                <option value="Madhya Pradesh" <?php if ($setting->state == "Madhya Pradesh") echo "selected"; ?>>Madhya Pradesh</option>
                                <option value="Maharashtra" <?php if ($setting->state == "Maharashtra") echo "selected"; ?>>Maharashtra</option>
                                <option value="Manipur" <?php if ($setting->state == "Manipur") echo "selected"; ?>>Manipur</option>
                                <option value="Meghalaya" <?php if ($setting->state == "Meghalaya") echo "selected"; ?>>Meghalaya</option>
                                <option value="Mizoram" <?php if ($setting->state == "Mizoram") echo "selected"; ?>>Mizoram</option>
                                <option value="Nagaland" <?php if ($setting->state == "Nagaland") echo "selected"; ?>>Nagaland</option>
                                <option value="Odisha" <?php if ($setting->state == "Odisha") echo "selected"; ?>>Odisha</option>
                                <option value="Puducherry" <?php if ($setting->state == "Puducherry") echo "selected"; ?>>Puducherry</option>
                                <option value="Punjab" <?php if ($setting->state == "Punjab") echo "selected"; ?>>Punjab</option>
                                <option value="Rajasthan" <?php if ($setting->state == "Rajasthan") echo "selected"; ?>>Rajasthan</option>
                                <option value="Sikkim" <?php if ($setting->state == "Sikkim") echo "selected"; ?>>Sikkim</option>
                                <option value="Tamil Nadu" <?php if ($setting->state == "Tamil Nadu") echo "selected"; ?>>Tamil Nadu</option>
                                <option value="Telangana" <?php if ($setting->state == "Telangana") echo "selected"; ?>>Telangana</option>
                                <option value="Tripura" <?php if ($setting->state == "Tripura") echo "selected"; ?>>Tripura</option>
                                <option value="Uttar Pradesh" <?php if ($setting->state == "Uttar Pradesh") echo "selected"; ?>>Uttar Pradesh</option>
                                <option value="Uttarakhand" <?php if ($setting->state == "Uttarakhand") echo "selected"; ?>>Uttarakhand</option>
                                <option value="West Bengal" <?php if ($setting->state == "West Bengal") echo "selected"; ?>>West Bengal</option>
                            </select>
                            <span class="error text-danger">{{ $errors->first('state') }}</span>
                        </div>
                        <div class="mb-1 col-md-4">
                            <label for="pincode" class="form-label">Pincode</label>
                            <input value="{{ old('pincode',$setting->pincode) }}" type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode">
                            <span class="error text-danger"> {{ $errors->first('pincode') }}</span>
                        </div>
                        <div class="mb-1 col-md-4">
                        </div>
                        <hr>
                        <h5 class=" mb-1 fs-16">Tax Details</h5>
                        <div class="mb-1 col-md-4">
                            <label for="gst" class="form-label">GST (TAX Number)</label>
                            <input value="{{ old('gst',$setting->gst) }}" type="text" class="form-control" id="gst" name="gst" placeholder="GST">
                            <span class="error text-danger"> {{ $errors->first('gst') }}</span>
                        </div>
                        <div class="mb-1 col-md-4">
                            <label for="pan" class="form-label">Pan</label>
                            <input value="{{ old('pan',$setting->pan) }}" type="text" class="form-control" id="pan" name="pan" placeholder="Pan">
                            <span class="error text-danger"> {{ $errors->first('pan') }}</span>
                        </div>
                        <div class="mb-1 col-md-4">
                        </div>
                        <hr>
                        <h5 class=" mb-1 fs-16">Invoice Setting</h5>
                        <div class="mb-1 col-md-4">
                            <label for="customer_prefix" class="form-label">Customer Prefix</label>
                            <input value="{{ old('customer_prefix',$setting->customer_prefix) }}" type="text" class="form-control" id="customer_prefix" name="customer_prefix" placeholder="Customer Prefix">
                            <span class="error text-danger"> {{ $errors->first('customer_prefix') }}</span>
                        </div>
                        <div class="mb-1 col-md-4">
                            <label for="invoice_prefix" class="form-label">Invoice Prefix</label>
                            <input value="{{ old('invoice_prefix',$setting->invoice_prefix) }}" type="text" class="form-control" id="invoice_prefix" name="invoice_prefix" placeholder="Invoice Prefix">
                            <span class="error text-danger"> {{ $errors->first('invoice_prefix') }}</span>
                        </div>
                        <div class="mb-1 col-md-4">
                            <label for="invoice_remarks" class="form-label">Invoice Remarks</label>
                            <textarea class="form-control" id="invoice_remarks" name="invoice_remarks">{{$setting->invoice_remarks}}</textarea>
                            <span class="error text-danger"> {{ $errors->first('invoice_remarks') }}</span>
                        </div>
                        <!-- Select Customer -->
                        <div class="mb-1 col-md-4">
                            <label for="default_customer_id" class="form-label">Default Customer</label>
                            <select class="form-select" id="default_customer_id" name="default_customer_id">
                                @if($setting->default_customer)
                                <option value="{{ $setting->default_customer->id }}">{{ $setting->default_customer->name ?? '' }} - {{ $setting->default_customer->mobile ?? '' }}</option>
                                @endif
                            </select>
                            <span class="error text-danger">{{ $errors->first('default_customer_id') }}</span>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.index') }}" class="btn btn-info">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {

        $('#default_customer_id').select2({
            placeholder: 'Search customer',
            allowClear: true,
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


    });
</script>

@endsection