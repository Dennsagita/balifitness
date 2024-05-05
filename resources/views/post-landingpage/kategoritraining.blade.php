@extends('layouts.app-landingpage')
@section('action')
@section('title', 'Kategori Training')
@endsection

@section('content')
  <main id="main">

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
      <div class="container">

        <div class="row mt-5">
          <div class="col-lg-12 d-flex justify-content-center">
            <h1>Kategori Training</h1>
          </div>
        </div>
       <!-- Dropdown kategori -->
        <div class="col-md-6 mb-3">
          <form action="{{ route('kategoritraining') }}" method="GET">
              <div class="input-group">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                      Kategori
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" id="kategoriDropdown">
                      <li><a class="dropdown-item" href="{{ route('kategoritraining') }}">SEMUA KATEGORI</a></li>
                      @foreach($kategori as $kat)
                          <li><a class="dropdown-item" href="{{ route('kategoritraining', ['kategori' => $kat->id]) }}">{{ $kat->nama }}</a></li>
                      @endforeach
                  </ul>
              </div>
          </form>
        </div>
        <div class="col-md-6 mb-3">
          <form action="{{ route('kategoritraining') }}" method="GET">
              <div class="input-group">
                  <input type="text" class="form-control" placeholder="Cari berdasarkan nama atau kategori" aria-label="Cari berdasarkan nama atau kategori" id="searchInput" name="keyword">
                  <button class="btn btn-outline-secondary" type="submit" id="searchButton">Cari</button>
              </div>
          </form>
        </div>
        <div class="row portfolio-container mt-5" id="portfolioContainer">
            @foreach($materi as $materi)
                <div class="col-lg-4 col-md-6 portfolio-item filter-app" data-kategori="{{ $materi->id_kategori }}" data-nama="{{ $materi->nama }}">
                  <a href="">
                    <div class="portfolio-wrap">
                        @if($materi->images && $materi->images->count())
                            <img src="{{ asset('storage/' . $materi->images->src) }}" class="img-fluid" alt="{{ $materi->nama }}">
                        @else
                            <img src="{{ asset('assets/img/materikosong.jpg') }}" class="img-fluid" alt="{{ $materi->nama }}">
                        @endif
                        <div class="portfolio-info">
                            <h4>{{ $materi->nama }}</h4>
                            <p>KATEGORI {{ $materi->kategori->nama }}</p>
                            <p>Pelatih : {{ $materi->coach->nama }}</p>
                            <div class="portfolio-links">
                                @if($materi->images && $materi->images->count())
                                    <a href="{{ asset('storage/' . $materi->images->src) }}" data-gallery="portfolioGallery" class="portfolio-lightbox" title="{{ $materi->nama }}"><i class="bx bx-plus"></i></a>
                                @else
                                    <a href="{{ asset('assets/img/materikosong.jpg') }}" data-gallery="portfolioGallery" class="portfolio-lightbox" title="{{ $materi->nama }}"><i class="bx bx-plus"></i></a>
                                @endif
                                <a href="{{ route('detailkategori', $materi->id) }}" class="portfolio-details-lightbox" data-glightbox="type: external" title="Portfolio Details">Detail</a>
                            </div>
                        </div>
                    </div>
                  </a>
                </div>
            @endforeach            
        </div>
      </div>
    </section><!-- End Portfolio Section -->

  </main><!-- End #main -->
@endsection
