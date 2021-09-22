<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{route('admin.dashboard',app()->getLocale())}}">Stisla</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{route('admin.dashboard',app()->getLocale())}}">St</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="@if($tab=='dashboard') active @endif"><a class="nav-link" href="{{route('admin.dashboard',app()->getLocale())}}"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
      <li class="menu-header">Starter</li>
      <li class="nav-item dropdown @if($tab=='product') active @endif">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Product</span></a>
        <ul class="dropdown-menu">
          @can('product-create')
            <li><a class="nav-link" href="{{ route('admin.product.create',app()->getLocale()) }}">Add</a></li>
          @endcan
          @can('product-list')
            <li><a class="nav-link" href="{{ route('admin.product.index',app()->getLocale()) }}">List</a></li>
          @endcan
        </ul>
      </li>
      @can('role-list')
        <li class="@if($tab=='role') active @endif"><a class="nav-link" href="{{route('admin.roles.index',app()->getLocale())}}"><i class="fas fa-fire"></i><span>Manage Role</span></a></li>
      @endcan
      <li><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li>
    </ul>
  </aside>
</div>