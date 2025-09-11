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
            <li class="breadcrumb-item"><a href="{{ route('category') }}">{{ ucfirst($moduleName) }}</a></li>
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
        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
          @csrf()
          <div class="row g-2">
            <div class="mb-3 col-md-4">
              <label for="name" class="form-label">Name</label>
              <input value="{{ old('name','') }}" type="text" class="form-control" id="name" name="name" placeholder="Name">
              <span class="error text-danger"> {{ $errors->first('name') }}</span>
            </div>
            <div class="mb-3 col-md-4">
              <label for="image" class="form-label">Image</label>
              <input type="file" class="form-control" id="image" name="image" accept="image/*">
              <span class="error text-danger">{{ $errors->first('image') }}</span>
            </div>
            <div class="mb-3 col-md-4">
              <label for="status" class="form-label">Status</label>
              <select id="status" name="status" class="form-select">
                <option value="1">Active</option>
                <option value="0">InActive</option>
              </select>
              <span class="error text-danger"> {{ $errors->first('status') }}</span>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
          <a href="{{ route('category') }}" class="btn btn-info">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection