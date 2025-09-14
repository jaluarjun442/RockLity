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
                <form action="{{ route('admin.profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf()
                    @method('PUT')
                    <div class="row g-2">
                        <!-- Name -->
                        <div class="mb-3 col-md-4">
                            <label for="name" class="form-label">Name</label>
                            <input value="{{ old('name',$user->name) }}"
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                placeholder="Name">
                            <span class="error text-danger">{{ $errors->first('name') }}</span>
                        </div>

                        <!-- Email -->
                        <div class="mb-3 col-md-4">
                            <label for="email" class="form-label">Email</label>
                            <input disabled value="{{ old('email',$user->email) }}"
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="Email">
                            <span class="error text-danger">{{ $errors->first('email') }}</span>
                        </div>

                        <!-- Mobile -->
                        <div class="mb-3 col-md-4">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input disabled value="{{ old('mobile',$user->mobile) }}"
                                type="text"
                                class="form-control"
                                id="mobile"
                                name="mobile"
                                placeholder="Mobile"
                                maxlength="12"
                                pattern="[0-9]{10,12}"
                                title="Enter a valid mobile number (10-12 digits)">
                            <span class="error text-danger">{{ $errors->first('mobile') }}</span>
                        </div>

                        <!-- Password -->
                        <div class="mb-3 col-md-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                placeholder="Password">
                            <span class="error text-danger">{{ $errors->first('password') }}</span>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3 col-md-4">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Confirm Password">
                            <span class="error text-danger">{{ $errors->first('password_confirmation') }}</span>
                        </div>

                        <hr>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.index') }}" class="btn btn-info">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection