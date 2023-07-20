  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin') ? '' : 'collapsed' }}" href="{{ route('dashboardAdmin') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/book*') ? '' : 'collapsed' }}" href="{{ route('admin.book_list') }}">
                    <i class="bi bi-clipboard"></i>
                    <span>Book</span>
                </a>
            </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/user*') ? '' : 'collapsed' }}" href="{{route('users.list')}}">
          <i class="bi bi-envelope"></i>
          <span>Users</span>
        </a>
      </li><!-- End Contact Page Nav -->
    <li class="nav-item">
      <a class="nav-link {{ request()->is('admin/borrowlist*') ? '' : 'collapsed' }}" href="{{route('borrow.list')}}">
        <i class="bi bi-list-ul"></i>
          <span>Borrow book</span>
      </a>
  </li>
    <!-- End Contact Page Nav -->

  </ul>

</aside><!-- End Sidebar-->
