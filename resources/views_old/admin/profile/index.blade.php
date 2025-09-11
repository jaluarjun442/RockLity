@extends('master')

@section('content')
<section class="content-header">
    <h1>
        User Profile
    </h1>

    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#" class="active">Profile</a></li>
    </ol>
</section>
<section class="content">

    <div class="box">

        <div class="box-body">
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        id="name"
                        name="name"
                        value="{{ old('name', auth()->user()->name) }}"
                        required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        value="{{ old('email', auth()->user()->email) }}"
                        required>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password">New Password (leave blank if not changing)</label>
                    <input type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="password"
                        name="password" autocomplete>
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password"
                        class="form-control"
                        id="password_confirmation"
                        name="password_confirmation">
                </div>

                <button type="submit" class="btn btn-theme">Update</button>
            </form>
        </div>
    </div>

</section>
@endsection