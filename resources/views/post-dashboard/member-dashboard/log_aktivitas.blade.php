@extends('layouts.app-dashboard')
@section('action')
@section('title', 'Member Log Aktivitas')
@endsection

@section('content')
<!-- Start Page Title -->
<main id="main" class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Member Log Aktivitas</h1>
                    <br>
                </div>
                <!-- End Page Title -->

                <!-- start JS untuk Validasi -->
                <!-- JS Validasi  -->

                @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <!-- End JS Validasi  -->
                @if($logaktivitas->isEmpty())
                    <p>Tidak ada log aktivitas.</p>
                @else
                @if (!$member->berat_badan_awal && !$member->target_berat_badan)
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Tambah Data Berat Badan</h5>
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
                        <form class="row g-3" action="{{ route('tambahberatbadan') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <label for="berat_badan_awal">Berat Badan</label>
                                        <input type="text" id="berat_badan_awal" name="berat_badan_awal" placeholder="Masukan Berat Badan Saat Ini" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="target_berat_badan">Target Berat Badan</label>
                                        <input type="text" id="target_berat_badan" name="target_berat_badan" placeholder="Masukan Target Berat Badan" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                              <button type="submit" class="btn btn-primary">Submit</button>
                              <button type="reset" class="btn btn-secondary">Reset</button>
                            </div> 
                          </form><!-- Vertical Form --> 
            
                        </div>
                      </div>
                </div>
                @else
                <div class="row">
                    @if ($errors->any())
                              <div class="alert alert-danger">
                                  <ul>
                                      @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                      @endforeach
                                  </ul>
                              </div>
                    @endif
                    <div class="col-md-6">
                        <div class="card p-4">
                            <h2>Data Berat Badan</h2>
                            <!-- Tempatkan deskripsi materi di sini -->
                            <p>Berat Badan Awal: {{ $member->berat_badan_awal }} KG</p>
                            <p>Berat Badan Saat Ini: {{ $member->berat_badan_sekarang ?? '-' }} KG</p>
                            <p>Selisih Berat Badan: {{ $member->berat_badan_awal ? ($member->berat_badan_sekarang ? $member->berat_badan_awal - $member->berat_badan_sekarang : '-') : '-' }} KG</p>
                            <h4>Target Berat Badan: {{ $member->target_berat_badan }} KG</h4>
                            <!-- Tambahkan informasi lainnya sesuai kebutuhan -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-4">
                           
                            @if($member->berat_badan_sekarang == 0)
                            <h2>Hitung Berat Badan</h2>
                            <form action="{{ route('hitungberatbadan') }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row gy-4">
                                    <div class="">
                                        <label for="berat_badan_sekarang">Berat Badan</label>
                                        <input type="text" class="form-control" name="berat_badan_sekarang" id="berat_badan_sekarang" placeholder="Masukan Berat badan">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </div>
                            </form>
                            @elseif($member->berat_badan_sekarang <= $member->target_berat_badan)
                            <h5>Selamat Target Berat Badan Terpenuhi</h5>
                            @else
                            <h2>Hitung Berat Badan</h2>
                            <form action="{{ route('hitungberatbadan') }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row gy-4">
                                    <div class="">
                                        <label for="berat_badan_sekarang">Berat Badan</label>
                                        <input type="text" class="form-control" name="berat_badan_sekarang" id="berat_badan_sekarang" placeholder="Masukan Berat badan">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="padding-bottom: 1rem;">Data Berat Badan</h5>
                        <div class="table-responsive">
                            <table class="table datatable table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Berat Badan</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $startNumber = 1;
                                    @endphp
                                    @foreach($beratbadan as $bb) <!-- Untuk menampilkan database sesuai dengan variabel di controller-->
                                    <tr>
                                        <td> <p>{{ $startNumber }}</p> </td>
                                        <td>{{ $bb->berat_badan}} KG</td>
                                        <td>{{ \Carbon\Carbon::parse($bb->created_at)->format('d-m-Y') }}</td>
                                    </tr>
                                    @php
                                    $startNumber++;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="padding-bottom: 1rem;">Log Aktivitas</h5>

                        <!-- Button tambah dan cetak data  -->
                        {{-- <a href="{{ route('tambahcoach') }}"><button type="button" class="btn btn-primary"> <i class="bi bi-plus-lg"></i> Tambah Data</button></a>  --}}
                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table datatable table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Id Log Aktivitas</th>
                                        <th>Nama Member</th>
                                        <th>Kategori</th>
                                        <th>Nama Materi</th>
                                        <th>Materi Coach</th>
                                        <th>Keterangan Memilih Materi</th>
                                        <th>Tanggal Pilih Materi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $startNumber = 1;
                                    @endphp
                                    @foreach($logaktivitas as $data=>$log) <!-- Untuk menampilkan database sesuai dengan variabel di controller-->
                                    <tr>
                                        <td> <p>{{ $startNumber }}</p> </td>
                                        <td>LGA-{{ \Carbon\Carbon::parse($log->created_at)->format('Ym') }}{{ $log->id }}</td>
                                        <td>{{ $log->member->nama}}</td>
                                        <td>{{ $log->materi->kategori->nama }}</td>
                                        <td>{{ $log->materi->nama }}</td>
                                        <td>{{ $log->materi->coach->nama }}</td>
                                        <td>{{ $log->deskripsi }}</td>
                                        <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d-m-Y') }}</td>
                                        <td class="align-items-center">
                                            <a href="{{ route('lihatmaterimember', ['logaktivitasid' => $log->id]) }}" class="btn btn-warning" >
                                                    <i class="bi bi-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                    @php
                                    $startNumber++;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</main>

  
@endsection