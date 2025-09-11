<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('public/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="{{ Request::is('admin') ? 'active' : '' }}">
        <a href="{{ url('admin') }}">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>

      <li class="{{ Request::is('admin/category') ? 'active' : '' }}">
        <a href="{{ url('admin/category') }}">
          <i class="fa fa-tag"></i> <span>Category</span>
        </a>
      </li>
      <li class="{{ Request::is('admin/product') ? 'active' : '' }}">
        <a href="{{ url('admin/product') }}">
          <i class="fa fa-tag"></i> <span>Product</span>
        </a>
      </li>
      <li class="{{ Request::is('admin/profile') ? 'active' : '' }}">
        <a href="{{route('admin.profile')}}">
          <i class="fa fa-user"></i> <span>Profile</span>
        </a>
      </li>
      <li class="{{ Request::is('admin/logout') ? 'active' : '' }}">
        <a href="#" class="logout">
          <i class="fa fa-sign-out"></i> <span>Logout</span>
        </a>
        <form action="{{route('logout')}}" method="post" id="logout">
          @csrf()
        </form>
      </li>
    </ul>
  </section>
</aside>