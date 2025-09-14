<!-- ========== Topbar Start ========== -->
<div class="navbar-custom">
  <div class="topbar container-fluid">
    <div class="d-flex align-items-center gap-lg-2 gap-1">

      <div class="logo-topbar">
        <a href="{{ url('admin') }}" class="logo-light">
          <span class="logo-lg">
            <img src="{{asset('public/uploads/setting/' . Helper::settings()->logo)}}" alt="logo">
          </span>
          <span class="logo-sm">
            <img src="{{asset('public/uploads/setting/' . Helper::settings()->logo)}}" alt="small logo">
          </span>
        </a>

        <a href="{{ url('admin') }}" class="logo-dark">
          <span class="logo-lg">
            <img src="{{asset('public/uploads/setting/' . Helper::settings()->logo)}}" alt="dark logo">
          </span>
          <span class="logo-sm">
            <img src="{{asset('public/uploads/setting/' . Helper::settings()->logo)}}" alt="small logo">
          </span>
        </a>
      </div>

      <!-- Sidebar Menu Toggle Button -->
      <button class="button-toggle-menu">
        <i class="ri-menu-2-fill"></i>
      </button>

      <!-- Horizontal Menu Toggle Button -->
      <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
        <div class="lines">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </button>
    </div>
    <ul class="topbar-menu d-flex align-items-center gap-3">
      <li class="dropdown d-lg-none">
        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
          <i class="ri-search-line fs-22"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg p-0">
          <form class="p-3">
            <input type="search" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
          </form>
        </div>
      </li>
      <li class="dropdown d-none d-sm-inline-block">
        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
          <i class="ri-apps-2-fill fs-22"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg p-0">

          <div class="p-2">
            <div class="row g-0">
              <div class="col">
                <a class="dropdown-icon-item" href="#">
                  <img src="{{ asset('public/assets/images/brands/github.png') }}" alt="Github">
                  <span>GitHub</span>
                </a>
              </div>
              <div class="col">
                <a class="dropdown-icon-item" href="#">
                  <img src="{{ asset('public/assets/images/brands/bitbucket.png') }}" alt="bitbucket">
                  <span>Bitbucket</span>
                </a>
              </div>
              <div class="col">
                <a class="dropdown-icon-item" href="#">
                  <img src="{{ asset('public/assets/images/brands/dropbox.png') }}" alt="dropbox">
                  <span>Dropbox</span>
                </a>
              </div>
            </div>

            <div class="row g-0">
              <div class="col">
                <a class="dropdown-icon-item" href="#">
                  <img src="{{ asset('public/assets/images/brands/slack.png') }}" alt="slack">
                  <span>Slack</span>
                </a>
              </div>
              <div class="col">
                <a class="dropdown-icon-item" href="#">
                  <img src="{{ asset('public/assets/images/brands/dribbble.png') }}" alt="dribbble">
                  <span>Dribbble</span>
                </a>
              </div>
              <div class="col">
                <a class="dropdown-icon-item" href="#">
                  <img src="{{ asset('public/assets/images/brands/behance.png') }}" alt="Behance">
                  <span>Behance</span>
                </a>
              </div>
            </div> 
          </div>

        </div>
      </li>

      <!-- <li class="d-none d-sm-inline-block">
        <a class="nav-link" data-bs-toggle="offcanvas" href="#theme-settings-offcanvas">
          <i class="ri-settings-3-fill fs-22"></i>
        </a>
      </li>

      <li class="d-none d-sm-inline-block">
        <div class="nav-link" id="light-dark-mode">
          <i class="ri-moon-fill fs-22"></i>
        </div>
      </li>


      <li class="d-none d-md-inline-block">
        <a class="nav-link" href="#" data-toggle="fullscreen">
          <i class="ri-fullscreen-line fs-22"></i>
        </a>
      </li> -->

      <li class="dropdown me-md-2">
        <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
          <span class="account-user-avatar">
            <img src="{{ asset('public/assets/images/users/avatar-1.jpg') }}" alt="user-image" width="32" class="rounded-circle">
          </span>
          <span class="d-lg-flex flex-column gap-1 d-none">
            <h5 class="my-0">{{ Auth::user()->name }}</h5>
            <!-- <h6 class="my-0 fw-normal">Founder</h6> -->
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
          <!-- item-->
          <div class=" dropdown-header noti-title">
            <h6 class="text-overflow m-0">Welcome !</h6>
          </div>

          <!-- item-->
          <a href="{{route('admin.index')}}" class="dropdown-item">
            <i class="ri-account-circle-fill align-middle me-1"></i>
            <span>My Account</span>
          </a>

          <!-- item-->
          <a href="{{route('admin.index')}}" class="dropdown-item">
            <i class="ri-settings-4-fill align-middle me-1"></i>
            <span>Settings</span>
          </a>
          <!-- item-->
          <a href="#" class="dropdown-item logout">
            <i class="ri-logout-box-fill align-middle me-1"></i>
            <span>Logout</span>
          </a>
          <form action="{{route('logout')}}" method="post" id="logout">
            @csrf()
          </form>
        </div>
      </li>
    </ul>
  </div>
</div>
<!-- ========== Topbar End ========== -->