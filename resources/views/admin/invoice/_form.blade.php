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
                <form action="{{ route('customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf()
                    @method('PUT')
                    <div class="row g-2">
                        <!-- Name -->
                        <div class="mb-3 col-md-4">
                            <label for="name" class="form-label">Name</label>
                            <input value="{{ old('name',$customer->name) }}" type="text" class="form-control" id="name" name="name" placeholder="Name">
                            <span class="error text-danger"> {{ $errors->first('name') }}</span>
                        </div>

                        <!-- Mobile -->
                        <div class="mb-3 col-md-4">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input value="{{ old('mobile',$customer->mobile) }}" type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile">
                            <span class="error text-danger"> {{ $errors->first('mobile') }}</span>
                        </div>

                        <!-- Email -->
                        <div class="mb-3 col-md-4">
                            <label for="email" class="form-label">Email</label>
                            <input value="{{ old('email',$customer->email) }}" type="email" class="form-control" id="email" name="email" placeholder="Email">
                            <span class="error text-danger"> {{ $errors->first('email') }}</span>
                        </div>

                        <!-- GST -->
                        <div class="mb-3 col-md-4">
                            <label for="gst" class="form-label">GST</label>
                            <input value="{{ old('gst',$customer->gst) }}" type="text" class="form-control" id="gst" name="gst" placeholder="GST Number">
                            <span class="error text-danger"> {{ $errors->first('gst') }}</span>
                        </div>

                        <!-- PAN -->
                        <div class="mb-3 col-md-4">
                            <label for="pan" class="form-label">PAN</label>
                            <input value="{{ old('pan',$customer->pan) }}" type="text" class="form-control" id="pan" name="pan" placeholder="PAN Number">
                            <span class="error text-danger"> {{ $errors->first('pan') }}</span>
                        </div>

                        <!-- Status -->
                        <div class="mb-3 col-md-4">
                            <label for="is_active" class="form-label">Status</label>
                            <select id="is_active" name="is_active" class="form-select">
                                <option value="0" {{ old('is_active',$customer->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                                <option value="1" {{ old('is_active',$customer->is_active) == 1 ? 'selected' : '' }}>Active</option>
                            </select>
                            <span class="error text-danger"> {{ $errors->first('is_active') }}</span>
                        </div>
                        <!-- Address -->
                        <div class="mb-3 col-md-4">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Address">{{ old('address',$customer->address) }}</textarea>
                            <span class="error text-danger"> {{ $errors->first('address') }}</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Update</button>
                    <a href="{{ route('customer') }}" class="btn btn-info"><i class="ri-close-line"></i> Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection