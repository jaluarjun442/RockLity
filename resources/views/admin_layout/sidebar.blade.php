    <!-- ========== Left Sidebar Start ========== -->
    <div class="leftside-menu">

      <!-- Brand Logo Light -->
      <a href="{{route('admin.index')}}" class="logo logo-light">
        <span class="logo-lg">
          <img src="{{ asset('public/assets/images/logo.png') }}" alt="logo">
        </span>
        <span class="logo-sm">
          <img src="{{ asset('public/assets/images/logo-sm.png') }}" alt="small logo">
        </span>
      </a>

      <!-- Brand Logo Dark -->
      <a href="{{route('admin.index')}}" class="logo logo-dark">
        <span class="logo-lg">
          <img src="{{ asset('public/assets/images/logo-dark.png') }}" alt="dark logo">
        </span>
        <span class="logo-sm">
          <img src="{{ asset('public/assets/images/logo-sm.png') }}" alt="small logo">
        </span>
      </a>

      <!-- Sidebar Hover Menu Toggle Button -->
      <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
      </div>

      <!-- Full Sidebar Menu Close Button -->
      <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
      </div>

      <!-- Sidebar -left -->
      <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user p-3 text-white">
          <a href="#" class="d-flex align-items-center text-reset">
            <div class="flex-shrink-0">
              <img src="{{ asset('public/assets/images/users/avatar-1.jpg') }}" alt="user-image" height="42" class="rounded-circle shadow">
            </div>
            <div class="flex-grow-1 ms-2">
              <span class="fw-semibold fs-15 d-block">{{ Auth::user()->name }}</span>
              <span class="fs-13">Admin</span>
            </div>
            <div class="ms-auto">
              <i class="ri-arrow-right-s-fill fs-20"></i>
            </div>
          </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">

          <li class="side-nav-title mt-1"> Main</li>

          <li class="side-nav-item {{ in_array(Route::currentRouteName(), ['admin.index']) ? 'menuitem-active' : '' }}">
            <a href="{{route('admin.index')}}" class="side-nav-link {{ in_array(Route::currentRouteName(), ['admin.index']) ? 'active' : '' }}">
              <i class="ri-dashboard-2-fill"></i>
              <span> Dashboard </span>
            </a>
          </li>
          <li class="side-nav-item {{ in_array(Route::currentRouteName(), ['category', 'category.create', 'category.edit']) ? 'menuitem-active' : '' }}">
            <a href="{{route('category')}}" class="side-nav-link">
              <i class="ri-price-tag-line"></i>
              <span> Category </span>
            </a>
          </li>

          <li class="side-nav-item {{ in_array(Route::currentRouteName(), ['product', 'product.create', 'product.edit']) ? 'menuitem-active' : '' }}">
            <a href="{{route('product')}}" class="side-nav-link">
              <i class="ri-shopping-bag-line"></i>
              <span> Product </span>
            </a>
          </li>

          <li class="side-nav-item {{ in_array(Route::currentRouteName(), ['admin.profile']) ? 'menuitem-active' : '' }}">
            <a href="{{route('admin.profile')}}" class="side-nav-link">
              <i class="ri-calendar-2-fill"></i>
              <span> Profile </span>
            </a>
          </li>

        </ul>
        <!--- End Sidemenu -->
        <div class="clearfix"></div>
      </div>
    </div>
    <!-- ========== Left Sidebar End ========== -->