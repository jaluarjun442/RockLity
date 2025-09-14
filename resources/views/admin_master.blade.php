<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>{{ Helper::settings()->name }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="#" name="description" />
  <meta content="#" name="author" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{asset('public/uploads/setting/' . Helper::settings()->favicon)}}">
  <!-- <link rel="shortcut icon" href="{{ asset('public/assets/images/favicon.ico') }}"> -->
  <!-- Daterangepicker css -->
  @include('admin_layout.headerscript')
  @yield('style')
</head>

<body>
  <!-- Begin page -->
  <div class="wrapper">



    @include('admin_layout.navbar')
    @include('admin_layout.sidebar')

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
      <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
          @yield('content')

        </div>
      </div>
      @include('admin_layout.footer')
    </div>
    @include('admin_layout.theme_setting')
    @include('admin_layout.footerscript')
    @yield('script')
    @include('admin_layout.common_component')
    <script>
      $(document).ready(function() {
        $('.logout').on('click', function(e) {
          e.preventDefault();
          $('#logout').submit();
        });
      });
    </script>
</body>

</html>