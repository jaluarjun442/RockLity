@extends('admin_master')

@section('content')
<section class="content-header">
    <h1>
        {{ ucfirst($moduleName) }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('product') }}">{{ ucfirst($moduleName) }}</a></li>
        <li><a href="#" active>Edit {{ ucfirst($moduleName) }}</a></li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit {{ ucfirst($moduleName) }}</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf()
                @method('PUT')
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="name">Name: *</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Product Name" value="{{ old('name',$product->name) }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="status">Status: *</label><br>
                                <span class="py-5"><input type="radio" name="status" value="1" {{ ($product->is_active == 1) ? 'checked' : ''}}> Active</span>
                                <span class="py-34"><input type="radio" name="status" value="0" {{ ($product->is_active == 0) ? 'checked' : ''}}> In
                                    Active</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-center">
                    <a href="{{ route('product') }}" class="btn btn-sm btn-default">Cancel</a>
                    <input type="submit" value="Submit" class="btn btn-sm btn-info">
                </div>
            </form>
        </div>
</section>
@endsection