@extends('layouts.app-dashboard')
@section('title', 'Pilih Materi')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Pilih Materi</h1>
    </div><!-- End Page Title -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="card p-4">
                <h2>Deskripsi Materi</h2>
                <!-- Tempatkan deskripsi materi di sini -->
                <p>Nama Materi: {{ $materi->nama }}</p>
                <p>Kategori: {{ $materi->kategori->nama }}</p>
                <p>Pelatih: {{ $materi->coach->nama }}</p>
                <br>
                <p>Deskripsi: {!! $materi->deskripsi !!}</p>
                <!-- Tambahkan informasi lainnya sesuai kebutuhan -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4">
                <h2>Pilih Materi Sekarang</h2>
                <form action="{{ route('prosespilihmateri') }}" method="post" >
                    @csrf
                    <div class="row gy-4">
                        <div class="col-md-6 d-none">
                            <input type="text" name="id_members" id="id_members" value="{{ Auth::guard('member')->user()->id }}" class="form-control">
                        </div>
                        <div class="col-md-6 d-none">
                            <input type="text" class="form-control" name="id_materi" id="id_materi" value="{{ $materi->id }}" >
                        </div>
                        <div class="col-md-12">
                            <label for="deskripsi">Keterangan Memilih Materi</label>
                            <textarea id="deskripsi" class="form-control" name="deskripsi" rows="6" placeholder="Masukan Keterangan Anda"></textarea>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                          </div> 
                    </div>
                </form>
            </div>
        </div>
    </div>

</main><!-- End #main -->
@endsection
