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
            <li class="breadcrumb-item"><a href="{{ route('product') }}">{{ ucfirst($moduleName) }}</a></li>
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
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
          @csrf()
          <div class="row g-2">
            <div class="mb-3 col-md-4">
              <label for="name" class="form-label">Name</label>
              <input value="{{ old('name') }}" type="text" class="form-control" id="name" name="name" placeholder="Name">
              <span class="error text-danger">{{ $errors->first('name') }}</span>
            </div>
            <div class="mb-3 col-md-4">
              <label for="sku" class="form-label">SKU</label>
              <input value="{{ old('sku') }}" type="text" class="form-control" id="sku" name="sku" placeholder="SKU">
              <span class="error text-danger">{{ $errors->first('sku') }}</span>
            </div>
            <div class="mb-3 col-md-4">
              <label for="category_id" class="form-label">Category</label>
              <select id="category_id" name="category_id" class="form-select">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
                @endforeach
              </select>
              <span class="error text-danger">{{ $errors->first('category_id') }}</span>
            </div>
            <div class="mb-3 col-md-4">
              <label for="price" class="form-label">Price</label>
              <input value="{{ old('price') }}" type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Price">
              <span class="error text-danger">{{ $errors->first('price') }}</span>
            </div>
            <div class="mb-3 col-md-4">
              <label for="discount" class="form-label">Discount</label>
              <input value="{{ old('discount') ?? 0 }}" type="number" step="0.01" class="form-control" id="discount" name="discount" placeholder="Discount">
              <span class="error text-danger">{{ $errors->first('discount') }}</span>
            </div>
            <div class="mb-3 col-md-4">
              <label for="unit_type" class="form-label">Unit Type</label>
              <select id="unit_type" name="unit_type" class="form-select">
                <option value="Piece" {{ old('unit_type') == 'Piece' ? 'selected' : '' }}>Piece</option>
                <option value="KG" {{ old('unit_type') == 'KG' ? 'selected' : '' }}>KG</option>
                <option value="Meter" {{ old('unit_type') == 'Meter' ? 'selected' : '' }}>Meter</option>
                <option value="Liter" {{ old('unit_type') == 'Liter' ? 'selected' : '' }}>Liter</option>
                <option value="Gram" {{ old('unit_type') == 'Gram' ? 'selected' : '' }}>Gram</option>
              </select>
              <span class="error text-danger">{{ $errors->first('unit_type') }}</span>
            </div>

            <div class="mb-3 col-md-4">
              <label for="image" class="form-label">Image</label>
              <input type="file" class="form-control" id="image" name="image" accept="image/*">
              <span class="error text-danger">{{ $errors->first('image') }}</span>
            </div>
            <div class="mb-3 col-md-12">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter description">{{ old('description') }}</textarea>
              <span class="error text-danger">{{ $errors->first('description') }}</span>
            </div>
            <div class="mb-3 col-md-4">
              <label for="status" class="form-label">Status</label>
              <select id="status" name="status" class="form-select">
                <option value="0" {{ old('status',0) == 0 ? 'selected' : '' }}>Inactive</option>
                <option value="1" {{ old('status',1) == 1 ? 'selected' : '' }}>Active</option>
              </select>
              <span class="error text-danger">{{ $errors->first('status') }}</span>
            </div>
          </div>
          <button type="submit" class="btn btn-primary"><i class="ri-edit-line"></i> Add</button>
          <a href="{{ route('product') }}" class="btn btn-info"><i class="ri-close-line"></i> Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection