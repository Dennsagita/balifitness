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
                </div>
                @endif
                <!-- End JS Validasi  -->
                @if($logaktivitas->isEmpty())
                    <p>Tidak ada log aktivitas.</p>
                @else
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