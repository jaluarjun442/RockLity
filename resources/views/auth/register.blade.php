<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Sign Up </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="#" name="description" />
    <meta content="#" name="author" />
    <link rel="shortcut icon" href="{{ asset('public/assets/images/favicon.ico') }}">
    <script src="{{ asset('public/assets/js/config.js') }}"></script>
    <link href="{{ asset('public/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('public/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg pb-0">
    <div class="auth-fluid">
        <div class="auth-fluid-right text-center">
        </div>
        <div class="auth-fluid-form-box">
            <div class="card-body d-flex flex-column h-100 gap-3">
                <!-- <div class="auth-brand text-center text-lg-start">
                    <a href="#" class="logo-dark">
                        <span><img src="{{ asset('public/assets/images/logo-dark.png') }}" alt="dark logo" height="24"></span>
                    </a>
                    <a href="#" class="logo-light">
                        <span><img src="{{ asset('public/assets/images/logo.png') }}" alt="logo" height="24"></span>
                    </a>
                </div> -->
                <div class="my-auto">
                    <h4 class="mt-0">Sign Up</h4>
                    <p class="text-muted mb-4">Enter your email address and password to create account.</p>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-1">
                            <label for="emailaddress" class="form-label">Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <label for="emailaddress" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <label for="password-confirm" class="form-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- <div class="mb-1">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                <label class="form-check-label" for="checkbox-signin">Remember me</label>
                            </div>
                        </div> -->
                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit"><i class="ri-login-box-line"></i> Sign Up </button>
                        </div>
                    </form>
                </div>
                <footer class="footer footer-alt">
                    <p class="text-muted">Already have an account? <a href="{{ route('login') }}" class="text-muted ms-1"><b>Sign In</b></a></p>
                </footer>
            </div>
        </div>
    </div>
    <script src="{{ asset('public/assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/app.min.js') }}"></script>
</body>

</html>