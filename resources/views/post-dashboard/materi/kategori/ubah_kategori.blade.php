@extends('layouts.app-dashboard')
@section('action')
@section('title', 'Ubah Kategori')
@endsection

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Form Ubah Kategori</h1>
      <br>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ubah Kategori</h5>
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
            <!-- Vertical Form -->
            <form class="row g-3" action="{{ route('kategori-update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Tambahkan method PUT untuk menandakan bahwa ini adalah permintaan update -->
                
                <!-- Input untuk nama kategori -->
                <div class="form-group">
                    <label for="nama">Nama Kategori</label>
                    <input type="text" id="nama" name="nama" class="form-control" value="{{ $kategori->nama }}">
                </div>
                
                <!-- Tombol submit dan reset -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>
            </div>
          </div>
      </div>
    </section>
    
  </main><!-- End #main -->
  @endsection

  