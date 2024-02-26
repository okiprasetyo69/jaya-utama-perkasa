 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('') }}img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Inventory App</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('') }}img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"> {{ auth()->user()->name }} </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          @if( auth()->user()->role == "superadmin")
          <li class="nav-item menu-open">
            <a href="#" class="nav-link  {{ request()->routeIs('inventory-admin') ||  request()->routeIs('sales-admin') || request()->routeIs('sales-admin') ? 'active' : '">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard Admin
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/management-category" class="nav-link {{ request()->routeIs('management-category') ? 'active' : '">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Management Kategory</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/management-product" class="nav-link  {{ request()->routeIs('/management-product') ? 'active' : '">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Management Product</p>
                </a>
              </li>
               
              <li class="nav-item">
                <a href="/management-inventory" class="nav-link {{ request()->routeIs('/management-inventory') ? 'active' : '">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Management Inventory</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
         
         

          @if( auth()->user()->role == "consumer")
          <li class="nav-item menu-open">
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/borrow-car" class="nav-link  {{ request()->routeIs('/borrow-car') ? 'active' : '">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pinjam Mobil</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/return-car" class="nav-link {{ request()->routeIs('/return-car') ? 'active' : '">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pengembalian Mobil</p>
                  </a>
                </li>
            </ul>
          </li>
          @endif

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>