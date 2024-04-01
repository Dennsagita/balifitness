@extends('layouts.app-dashboard')
@section('action')
@section('title', 'Tambah Data Coach')
@endsection

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Form Tambah Data Coach</h1>
      <br>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Tambah Data</h5>
              <!-- Vertical Form -->
              <form class="row g-3" action="{{ route('coach-insert') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Hidden field for ID with auto increment -->
                <div class="col-12">
                    <label for="nama" class="form-label">Nama Coach</label>
                    <input type="text" name="nama" class="form-control" id="nama">
                </div>
                <div class="col-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email">
                </div>          
                <div class="col-12">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>          
                <div class="col-12">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control" id="alamat">
                </div>          
                <div class="col-12">
                    <label for="no_telp" class="form-label">No Telphone</label>
                    <input type="text" name="no_telp" class="form-control" id="no_telp">
                </div>          
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- Vertical Form -->

            </div>
          </div>
      </div>
    </section>

  </main><!-- End #main -->
@endsection