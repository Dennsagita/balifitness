@extends('layouts.app-dashboard')
@section('action')
@section('title', 'Ubah Data Materi')
@endsection

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Form Pengajuan Peminjaman</h1>
      <br>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ubah Data Materi</h5>
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
            <form class="row g-3" action="{{ route('materi-update', $materi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                            <!-- Sarana (pilihan dengan dropdown select) -->
                            <div class="form-group">
                              <label for="id_kategori">Kategori</label>
                              <select class="form-select" name="id_kategori" id="id_kategori" >
                                  <option value="{{ $materi->kategori->id }}">{{ $materi->kategori->nama }}</option>
                                  @foreach($kategori as $kategori)
                                      <option value="{{ $kategori->id }}">
                                          {{ $kategori->nama }}
                                      </option>
                                  @endforeach
                              </select>
                            </div>

                            <!-- Sarana (pilihan dengan dropdown select) -->
                            <div class="form-group">
                              <label for="id_coach">Coach</label>
                              <select class="form-select" name="id_coach" id="id_coach" >
                                  <option value="{{ $materi->coach->id }}">{{ $materi->coach->nama }}</option>
                                  @foreach($coach as $coach)
                                      <option value="{{ $coach->id }}">
                                          {{ $coach->nama }}
                                      </option>
                                  @endforeach
                              </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" id="nama" name="nama" value="{{ $materi->nama }}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="link_video">Link Video</label>
                                <input type="text" id="link_video" name="link_video" value="{{ $materi->link_video }}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="tinymce-editor" style="color: white;" id="deskripsi" name="deskripsi" required>
                                <p>{{ $materi->deskripsi }}</p>
                              </textarea>
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

  