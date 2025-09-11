<header class="main-header">
  <a href="{{ url('admin') }}" class="logo">
    <span class="logo-mini">
      <h3>A</h3>
      {{-- <img src="{{ asset('public/dist/img/logo-mini.png') }}" alt="logo" class="img-responsive"> --}}
    </span>
    <span class="logo-xl">
      {{-- <img src="{{ asset('public/setting/logo.png') }}" alt="logo" class="img-responsive"> --}}
      <h3>Admin</h3>
    </span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- <div class="searcharea">
      <input type="text" class="form-control" id="searchbar" name="search" placeholder="Search...">
    </div> -->

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        {{-- <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-users"></i>
              <span class="label label-success">4</span>
            </a>

          </li> --}}
        {{-- <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-comments" aria-hidden="true"></i>
              <span class="label label-warning">10</span>
            </a>
          </li> --}}

        
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            <img src="{{ asset('public/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs"></span>
          </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
              <img src="{{ asset('public/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

              <p>
                {{Auth::user()->name}}
                <small>{{date('d-M-Y',strtotime(Auth::user()->updated_at)) }}</small>
              </p>
            </li>

            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="{{route('admin.profile')}}" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="#" class="btn btn-default btn-flat logout">Sign out</a>
                <form action="{{route('logout')}}" method="post" id="logout">
                  @csrf()
                </form>
              </div>
            </li>
          </ul>
        </li>
        <!-- <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user" aria-hidden="true"></i>
              <span class="hidden-xs">Zamblek</span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="#">Profile</a></li>
                <li><a href="index.html">Logout</a></li>
            </ul>
          </li> -->
      </ul>
    </div>
  </nav>
</header>