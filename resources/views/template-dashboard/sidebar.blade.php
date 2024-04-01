 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed {{ request()->segment(1) == 'dashboard' ? 'bg-primary text-white' : '' }}" href="{{ route('dashboard') }}">
          <i class="bi bi-grid{{ request()->segment(1) == 'dashboard' ? ' text-white' : '' }}"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-heading">MANAGEMENT MEMBER</li>
      <li class="nav-item">
        <a class="nav-link collapsed  {{ request()->segment(1) == 'datamember' ? 'bg-primary text-white' : '' }}" href="{{ route('datamember') }}">
          <i class="bi bi-person {{ request()->segment(1) == 'datamember' ? ' text-white' : '' }}"></i>
          <span>MEMBER</span>
        </a>
      </li><!-- End MEMBER Page Nav -->

      <li class="nav-heading">MANAGEMENT COACH</li>
      <li class="nav-item">
        <a class="nav-link collapsed {{ request()->segment(1) == 'datacoach' ? 'bg-primary text-white' : '' }} 
          {{ request()->segment(1) == 'tambah-coach' ? 'bg-primary text-white' : '' }}" href="{{ route('datacoach') }}">
          <i class="bi bi-people-fill{{ request()->segment(1) == 'datacoach' ? ' text-white' : '' }}
            {{ request()->segment(1) == 'tambah-coach' ? ' text-white' : '' }}"></i>
          <span>COACH</span>
        </a>
      </li><!-- End COACH Page Nav -->
      

      <li class="nav-heading">MANAGEMENT MATERI</li>
      <li class="nav-item">
        <a class="nav-link collapsed {{ request()->segment(1) == 'datamateri' ? 'bg-primary text-white' : '' }}" href="{{ route('datamateri') }}">
          <i class="bi bi-envelope {{ request()->segment(1) == 'datamateri' ? ' text-white' : '' }}"></i>
          <span>MATERI</span>
        </a>
      </li><!-- End MATERI Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-register.html">
          <i class="bi bi-card-list"></i>
          <span>LOG AKTIVITAS</span>
        </a>
      </li><!-- End LOG AKTIVITAS Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('logout') }}">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Logout</span>
        </a>
      </li><!-- End Logout Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->