@extends('layouts.app-dashboard')
@section('title', 'Dashboard Member')
@section('foto', 'agus')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- Dropdown kategori -->
            <div class="col-md-6 mb-3">
                <form action="{{ route('materi-member') }}" method="GET">
                    <div class="input-group">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Kategori
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="{{ route('materi-member') }}">SEMUA KATEGORI</a></li>
                            @foreach($kategori as $kat)
                                <li><a class="dropdown-item" href="{{ route('materi-member', ['kategori' => $kat->id]) }}">{{ $kat->nama }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </form>
            </div>
            <div class="col-md-6 mb-3">
                <form action="{{ route('materi-member') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari berdasarkan nama atau kategori" aria-label="Cari berdasarkan nama atau kategori" id="searchInput" name="keyword">
                        <button class="btn btn-outline-secondary" type="submit" id="searchButton">Cari</button>
                    </div>
                </form>
            </div>            
        </nav>
    </div><!-- End Page Title -->
    
    <div class="card-container">
        <div class="row">
            @foreach($materi as $materi)
            <div class="col-md-4">
                <a href="{{ route('pilihmateri', $materi->id) }}">
                    <div class="card" data-kategori="{{ $materi->kategori->id }}">
                        @if($materi->images && $materi->images->count())
                        <img src="{{ asset('storage/' . $materi->images->src) }}" class="card-img-top" alt="{{ $materi->nama }}">
                        @else
                        <img src="{{ asset('assets/img/materikosong.jpg') }}" class="card-img-top" alt="{{ $materi->nama }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $materi->nama }}</h5>
                            <h8 class="card-title">KATEGORI {{ $materi->kategori->nama }}</h8>
                            <p class="card-text">Pelatih : {{ $materi->coach->nama }}</p>
                        </div>
                    </div><!-- End Card with an image on top -->
                </a>
            </div>
            @endforeach
        </div>
    </div>
     <!-- Rekomendasi Materi Paling Banyak Dipilih -->
     @if($topMateri)
     <div class="card">
         <div class="card-body">
             <h5 class="card-title">Rekomendasi Materi</h5>
             <div class="card">
                 <img src="{{ $topMateri->images ? asset('storage/' . $topMateri->images->src) : asset('assets/img/materikosong.jpg') }}" class="card-img-top" alt="{{ $topMateri->nama }}">
                 <div class="card-body">
                     <h5 class="card-title">{{ $topMateri->nama }}</h5>
                     <p>{{ $topMateri->log_count }} Member memilih materi ini</p>
                     <a href="{{ route('pilihmateri', $topMateri->id) }}" class="btn btn-primary">Lihat Materi</a>
                 </div>
             </div>
         </div>
     </div>
 @else
     <div class="alert alert-info">Belum ada materi yang dipilih.</div>
 @endif

</main><!-- End #main -->
@endsection
