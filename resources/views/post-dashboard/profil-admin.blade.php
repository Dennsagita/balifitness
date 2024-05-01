@extends('layouts.app-dashboard')
@section('title', 'Profil Admin')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="d-flex align-items-center">
                <div>
                    <strong>Peringatan!</strong>
                    <div>
                        <ul class="mt-1.5 ml-4 list-unstyled">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(Session::has('editadmin'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('editadmin') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="col-xl-4">
          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                @if($admin->images && $admin->images->count())
                    <img src="{{ asset('storage/' . $admin->images->src) }}" class="rounded-circle" alt="{{ $admin->nama }}">
                @else
                    <img src="{{ asset('assets/img/profilekosong.jpg') }}" class="rounded-circle" alt="{{ $admin->nama }}">
                @endif
                @if (Str::length(Auth::guard('admin')->user()) > 0)
                <h2>{{ Auth::user()->nama}}</h2>
                <h3>{{ Auth::user()->email}}</h3>
                @endif
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                    @if (Str::length(Auth::guard('admin')->user()) > 0)
                    <h5 class="card-title">Profile Details</h5>
                    {{-- @elseif (Str::length(Auth::guard('web')->user()) > 0) --}}
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Nama</div>
                      <div class="col-lg-9 col-md-8">: {{ Auth::user()->nama}}</div>
                    </div>
    
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Email</div>
                      <div class="col-lg-9 col-md-8">: {{ Auth::user()->email}}</div>
                    </div>
    
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Nomor Telphone</div>
                      <div class="col-lg-9 col-md-8">: {{ Auth::user()->no_telp}}</div>
                    </div>
    
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Alamat</div>
                      <div class="col-lg-9 col-md-8">: {{ Auth::user()->alamat}}</div>
                    </div>
                  </div>
    
                  <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
    
                    <!-- Profile Edit Form -->
                    <form action="{{ route('updateadmin') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                    <div class="col-md-8 col-lg-9">
                        @if($admin->images && $admin->images->count())
                            <img src="{{ asset('storage/' . $admin->images->src) }}" alt="{{ $admin->nama }}">
                        @else
                            <img src="{{ asset('assets/img/profilekosong.jpg') }}" alt="{{ $admin->nama }}">
                        @endif
                        <div class="pt-2">
                            <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                            <input type="file" name="image" accept="image/*" multiple data-max_length="20">
                        </div>
                    </div>
                    </div>
                      <div class="row mb-3">
                        <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="nama" type="text" class="form-control" id="nama" value="{{ Auth::user()->nama}}">
                        </div>
                      </div>
    
                      <div class="row mb-3">
                        <label for="no_telp" class="col-md-4 col-lg-3 col-form-label">No Telphone</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="no_telp" type="text" class="form-control" id="no_telp" value="{{ Auth::user()->no_telp}}">
                        </div>
                      </div>
    
                      <div class="row mb-3">
                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="email" type="text" class="form-control" id="email" value="{{ Auth::user()->email}}">
                        </div>
                      </div>
    
                      <div class="row mb-3">
                        <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="alamat" type="text" class="form-control" id="alamat" value="{{ Auth::user()->alamat}}">
                        </div>
                      </div>
    
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                      </div>
                    </form><!-- End Profile Edit Form -->
    
                  </div>
                  @endif

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form action="{{ route('ubahpasswordadmin') }}" method="post">
                    @csrf
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Password Lama</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="old_password" type="password" class="form-control" id="old_password">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Password Baru</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="new_password" type="password" class="form-control" id="new_password">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Konfirmasi Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="new_password_confirm" type="password" class="form-control" id="new_password_confirm">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" id="profile-change-password">Ubah Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->
  @endsection