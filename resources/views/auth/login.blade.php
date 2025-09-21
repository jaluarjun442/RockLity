<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Sign In </title>
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
                    <h4 class="mt-0">Sign In</h4>
                    <p class="text-muted mb-4">Enter your email address and password to access account.</p>
                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('login') }}" method="POST">
                        @csrf()
                        <div class="mb-1">
                            <label for="emailaddress" class="form-label">Email address</label>
                            <input class="form-control" type="email" name="email" id="email" required="" placeholder="Enter your email">
                        </div>
                        <div class="mb-1">
                            <!-- <a href="auth-recoverpw-2.html" class="text-muted float-end"><small>Forgot your password?</small></a> -->
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control" type="password" name="password" required="" id="password" placeholder="Enter your password">
                        </div>
                        <!-- <div class="mb-1">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                <label class="form-check-label" for="checkbox-signin">Remember me</label>
                            </div>
                        </div> -->
                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit"><i class="ri-login-box-line"></i> Log In </button>
                        </div>
                    </form>
                </div>
                <footer class="footer footer-alt">
                    <p class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-muted ms-1"><b>Sign Up</b></a></p>
                </footer>
            </div>
        </div>
    </div>
    <script src="{{ asset('public/assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/app.min.js') }}"></script>
</body>

</html>