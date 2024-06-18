@extends('layouts.app-landingpage')
@section('action')
@section('title', 'Tentang Kami')
@endsection

@section('content')
<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>About</h2>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row content">
          <div class="col-lg-6">
            <h2>BALI FITNESS SEMINYAK</h2>
            <h3>Selamat datang di Bali Fitness Seminyak, pusat kebugaran terkemuka yang berkomitmen untuk membantu Anda mencapai kebugaran.
            </h3>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <p>
              fasilitas kami menawarkan lingkungan yang inspiratif dan mendukung untuk semua level kebugaran, dari pemula hingga atlet profesional.
              Kami menawarkan berbagai program kebugaran yang dapat disesuaikan dengan kebutuhan dan tujuan Anda, termasuk:
            </p>
            <ul>
              <li><i class="ri-check-double-line"></i> Personal Training: Sesi latihan pribadi dengan pelatih profesional yang akan membuat program latihan yang sesuai dengan kebutuhan dan tujuan Anda.</li>
              <li><i class="ri-check-double-line"></i> Program Calisthenic: Latihan berbasis berat tubuh yang fokus pada kekuatan, fleksibilitas, dan keterampilan tubuh.</li>
              <li><i class="ri-check-double-line"></i> Rehabilitasi dan Pemulihan: Program khusus untuk pemulihan cedera dan peningkatan mobilitas serta kekuatan tubuh.</li>
            </ul>
            <p class="fst-italic">
              Bergabunglah dengan kami di Bali Fitness Seminyak dan mulailah perjalanan Anda menuju kebugaran dan kesejahteraan. Dengan fasilitas unggulan, program yang komprehensif, dan dukungan dari tim profesional kami, Anda akan menemukan bahwa mencapai tujuan kebugaran Anda lebih mudah dan menyenangkan.
            </p>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Team Section ======= -->
    <section id="team" class="team section-bg">
      <div class="container">

        <div class="section-title">
          <h2>Coach</h2>
          <p>Our Coach</p>
        </div>

        <div class="row">
        @foreach($coach as $item)  
        <div class="col-lg-6 mt-4">
            <div class="member d-flex align-items-start">
              <div class="pic">
                @if($item->images && $item->images->count())
                  <img src="{{ asset('storage/' . $item->images->src) }}" class="img-fluid" alt="{{ $item->nama }}">
                @else
                  <img src="{{ asset('assets/landingpage/assets/img/profilekosong.jpg') }}" class="img-fluid" alt="{{ $item->nama }}">
                @endif
              </div>
              <div class="member-info">
                <h4>{{ $item->nama }}</h4>
                <span>{{ $item->email }}</span>
                <p>{{ $item->alamat }}</p>
                <div class="social">
                  <p>@balifitnessseminyak</p>
                </div>
              </div>
            </div>
        </div>
        @endforeach
        </div>

      </div>
    </section><!-- End Team Section -->

  </main><!-- End #main -->

@endsection
