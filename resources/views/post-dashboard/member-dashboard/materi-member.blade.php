@extends('layouts.app-dashboard')
@section('title', 'Dashboard Member')

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
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                Kategori
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#" data-kategori="all">SEMUA KATEGORI</a></li>
                @foreach($kategori as $kat)
                  <li><a class="dropdown-item" href="#" data-kategori="{{ $kat->id }}">{{ $kat->nama }}</a></li>
                @endforeach
              </ul>
            </div>
          
            <!-- End Dropdown kategori -->
        </nav>
    </div><!-- End Page Title -->
    <div class="card-container">
        <div class="row">
            @foreach($materi as $materi)
            <div class="col-md-4">
                <a href="{{ route('pilihmateri', $materi->id) }}">
                    <div class="card" data-kategori="{{ $materi->kategori->id }}">
                        <img src="assets/img/card.jpg" class="card-img-top" alt="...">
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
<!-- JavaScript untuk menangani tindakan ketika item dropdown dipilih -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
      // Ambil semua item dropdown
      var dropdownItems = document.querySelectorAll('.dropdown-item');

      // Tambahkan event listener untuk setiap item dropdown
      dropdownItems.forEach(function(item) {
          item.addEventListener('click', function() {
              // Ambil nilai data-kategori dari item dropdown yang dipilih
              var selectedCategory = item.dataset.kategori;

              // Saring materi berdasarkan kategori yang dipilih
              var cards = document.querySelectorAll('.card');
              cards.forEach(function(card) {
                  var cardCategory = card.dataset.kategori;
                  if (selectedCategory === 'all' || selectedCategory === cardCategory) {
                      card.style.display = 'block';
                      // Pindahkan card yang dipilih ke posisi paling depan
                      if (selectedCategory === cardCategory) {
                          card.parentNode.prepend(card); // Pindahkan card ke depan
                      }
                  } else {
                      card.style.display = 'none';
                  }
              });
          });
      });
  });
</script>

</main><!-- End #main -->
@endsection
