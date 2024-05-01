<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center bg-primary text-white">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        {{-- <img src="assets/img/logo.png" alt=""> --}}
        <span class="d-none d-lg-block text-white">Bali Fitness Seminyak</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn text-white"></i>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown">


        <li class="nav-item dropdown pe-3">
          @if (Str::length(Auth::guard('admin')->user()) > 0)
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            @if($admin->images && $admin->images->count())
              <img src="{{ asset('storage/' . $admin->images->src) }}" alt="{{ $admin->nama }}"  class="rounded-circle">
            @else
              <img src="{{ asset('assets/img/profilekosong.jpg') }}" alt="{{ $admin->nama }}"  class="rounded-circle">
            @endif
            <span class="d-none d-md-block dropdown-toggle ps-2 text-white">{{ Auth::guard('admin')->user()->nama }}</span>
          </a><!-- End Profile Iamge Icon -->
          @elseif (Str::length(Auth::guard('member')->user()) > 0)
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            @if($member->images && $member->images->count())
              <img src="{{ asset('storage/' . $member->images->src) }}" alt="{{ $member->nama }}"  class="rounded-circle">
            @else
              <img src="{{ asset('assets/img/profilekosong.jpg') }}" alt="{{ $member->nama }}"  class="rounded-circle">
            @endif
            <span class="d-none d-md-block dropdown-toggle ps-2 text-white">{{ Auth::guard('member')->user()->nama }}</span>
          </a><!-- End Profile Iamge Icon -->
          @elseif (Str::length(Auth::guard('coach')->user()) > 0)
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2 text-white">{{ Auth::guard('coach')->user()->nama }}</span>
          </a><!-- End Profile Iamge Icon -->
          @endif

          @if (Str::length(Auth::guard('admin')->user()) > 0)
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ Auth::guard('admin')->user()->nama }}</h6>
              <span>{{ Auth::guard('admin')->user()->email }}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('profiladmin') }}">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul><!-- End Profile Dropdown Items -->

          @elseif (Str::length(Auth::guard('member')->user()) > 0)
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ Auth::guard('member')->user()->nama }}</h6>
              <span>{{ Auth::guard('member')->user()->email }}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('profilmember') }}">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul><!-- End Profile Dropdown Items -->

          @elseif (Str::length(Auth::guard('coach')->user()) > 0)
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Kevin Anderson</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul><!-- End Profile Dropdown Items -->
          @endif
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->