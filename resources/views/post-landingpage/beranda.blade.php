@extends('layouts.app-landingpage')
@section('action')
@section('title', 'Beranda')
@endsection

@section('content')
 <!-- ======= Hero Section ======= -->
 <section id="hero">
    <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

      <div class="carousel-inner" role="listbox">

        <!-- Slide 1 -->
        <div class="carousel-item active" style="background-image: url({{ asset('assets/landingpage/assets/img/slide/foto2.jpg') }})">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown">Selamat Datang di <span>Bali Fitness Seminyak</span></h2>
              <p class="animate__animated animate__fadeInUp">Temukan tempat terbaik untuk mencapai kebugaran optimal. Dengan fasilitas modern dan pelatih berpengalaman, kami siap mendukung perjalanan kebugaran Anda.</p>
              <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Baca Selengkapnya</a>
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item" style="background-image: url({{ asset('assets/landingpage/assets/img/slide/foto1.jpg') }})">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown">Program Latihan Calisthenic yang Disesuaikan</h2>
              <p class="animate__animated animate__fadeInUp">Dapatkan program latihan calisthenic yang dirancang khusus untuk Anda. Mulai dari gerakan dasar hingga teknik lanjutan, kami siap membantu Anda mencapai kekuatan dan fleksibilitas yang optimal.</p>
              <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Baca Selengkapnya</a>
            </div>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item" style="background-image: url({{ asset('assets/landingpage/assets/img/slide/foto3.jpg') }})">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown">Keunggulan Kebugaran dengan Calisthenic</h2>
              <p class="animate__animated animate__fadeInUp">Calisthenic menawarkan manfaat kebugaran menyeluruh tanpa peralatan berat. Kembangkan kekuatan tubuh, keseimbangan, dan daya tahan melalui latihan yang dapat dilakukan di mana saja.</p>
              <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Baca Selengkapnya</a>
            </div>
          </div>
        </div>

      </div>

      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>

    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row content">
          <div class="col-lg-6">
            <h2>Apa Itu Calisthenic</h2>
            <h3>Calisthenic adalah bentuk latihan fisik yang menggunakan berat tubuh sendiri untuk meningkatkan kekuatan, fleksibilitas, dan kebugaran keseluruhan.</h3>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <p>
              Latihan ini tidak memerlukan peralatan berat atau fasilitas khusus, sehingga bisa dilakukan di berbagai tempat seperti rumah, taman, atau ruang terbuka lainnya. 
              Beberapa contoh gerakan calisthenic meliputi push-up, pull-up, squat, dan plank, yang semuanya memanfaatkan berat tubuh sendiri untuk menantang dan memperkuat otot-otot tubuh.
              Calisthenic memiliki banyak keunggulan dibandingkan bentuk latihan lainnya. Salah satunya adalah kemampuan untuk meningkatkan kebugaran fungsional, yang berarti latihan ini membantu memperbaiki cara tubuh bergerak dalam kehidupan sehari-hari. 
            </p>
            <ul>
              <li><i class="ri-check-double-line"></i> BUILDING MUSCLE </li>
              <li><i class="ri-check-double-line"></i> CARDIO</li>
              <li><i class="ri-check-double-line"></i> REHABILITATION</li>
              <li><i class="ri-check-double-line"></i> SKILL</li>
            </ul>
            <p class="fst-italic">
              Latihan calisthenic efektif untuk meningkatkan kekuatan otot seluruh tubuh. Gerakan dinamis dan statis dalam calisthenic membantu meningkatkan fleksibilitas tubuh.
              Latihan ini membantu memperbaiki keseimbangan dan koordinasi tubuh.
            </p>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="row">
          <div class="col-md-6">
            <div class="icon-box">
              <i class="bi bi-briefcase"></i>
              <h4><a href="#">BUILDING MUSCLE</a></h4>
              <p>Building muscle melalui calisthenic adalah proses meningkatkan massa otot dengan menggunakan berat tubuh sendiri sebagai resistensi. Latihan-latihan seperti push-up, pull-up, dan squat menargetkan berbagai kelompok otot untuk merangsang pertumbuhan dan kekuatan otot. </p>
            </div>
          </div>
          <div class="col-md-6 mt-4 mt-md-0">
            <div class="icon-box">
              <i class="bi bi-card-checklist"></i>
              <h4><a href="#">CARDIO</a></h4>
              <p>Cardio dalam konteks calisthenic melibatkan latihan yang meningkatkan detak jantung dan sirkulasi darah dengan menggunakan gerakan tubuh yang dinamis dan ritmis. Contoh latihan cardio calisthenic meliputi burpees, jumping jacks, dan mountain climbers.</p>
            </div>
          </div>
          <div class="col-md-6 mt-4 mt-md-0">
            <div class="icon-box">
              <i class="bi bi-bar-chart"></i>
              <h4><a href="#">REHABILITATION</a></h4>
              <p>Rehabilitation melalui calisthenic adalah proses pemulihan fungsi fisik setelah cedera atau penyakit dengan menggunakan latihan berbasis berat tubuh. Latihan rehabilitasi calisthenic fokus pada gerakan yang aman dan terkontrol untuk memperkuat otot, meningkatkan mobilitas, dan memulihkan keseimbangan serta koordinasi.</p>
            </div>
          </div>
          <div class="col-md-6 mt-4 mt-md-0">
            <div class="icon-box">
              <i class="bi bi-binoculars"></i>
              <h4><a href="#">SKILL</a></h4>
              <p>Skill dalam calisthenic merujuk pada kemampuan untuk melakukan gerakan atau teknik tertentu dengan tingkat kemahiran yang tinggi. Keterampilan calisthenic mencakup berbagai teknik mulai dari dasar hingga lanjutan, seperti handstand, muscle-up, dan planche. Mengembangkan keterampilan ini memerlukan latihan berulang, ketekunan, dan peningkatan progresif. </p>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Services Section -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
      <div class="container">

        <div class="row">
          <div class="col-lg-12 d-flex justify-content-center">
            <h1>Kategori Training</h1>
          </div>
        </div>

        <div class="row portfolio-container">
            @php    
                $materi_random = $materi->shuffle();
                $counter = 0 
            @endphp
            @foreach($materi as $materi)
                <div class="col-lg-4 col-md-6 portfolio-item filter-app">
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
                            </div>
                        </div>
                    </div>
                </div>
                @php $counter++ @endphp
                @if($counter == 3)
                    @break
                @endif
            @endforeach            
        </div>
      </div>
    </section><!-- End Portfolio Section -->

  </main><!-- End #main -->

  
@endsection