@extends('layouts.app-dashboard')
@section('action')
@section('title', 'Log Aktivitas')
@endsection

@section('content')
<!-- Start Page Title -->
<main id="main" class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Member Materi</h1>
                    <br>
                </div>
                <!-- End Page Title -->

                <!-- start JS untuk Validasi -->
                <!-- JS Validasi  -->

                @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @elseif(Session::has('delete'))
                <div class="alert alert-success" role="alert">
                    {{ session('delete') }}
                </div>
                @elseif(Session::has('edit'))
                <div class="alert alert-success" role="alert">
                    {{ session('edit') }}
                </div>
                @endif
                <!-- End JS Validasi  -->
                <!-- Start Table -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="padding-bottom: 1rem;">Materi</h5>
                        <h1>{{ $materi->nama }}</h1>
                        <p>Deskripsi: {!! $materi->deskripsi !!}</p>
                        <p>Kategori: {{ $materi->kategori->nama }}</p>
                        <p>Coach: {{ $materi->coach->nama }}</p>
                        <p>Link Video: <a href="{{ $materi->link_video }}" target="_blank">{{ $materi->link_video }}</a></p>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="{{ $materi->link_video }}" allow="autoplay"></iframe>
                        </div>
                        </div>
                    </div>
                </div>                
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="padding-bottom: 1rem;">Data Proses Pelatihan</h5>
                                                
                        <div class="table-responsive">
                            <table class="table datatable table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Link Proses Latihan</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $startNumber = 1;
                                    @endphp
                                    @forelse($monitorings as $monitoring)
                                    <tr>
                                        <td><p>{{ $startNumber }}</p></td>
                                        <td><a href="{{ $monitoring->link }}" target="_blank">{{ $monitoring->link }}</a></td>
                                        <td>{{ \Carbon\Carbon::parse($monitoring->created_at)->format('d-m-Y') }}</td>
                                    </tr>
                                    @php
                                    $startNumber++;
                                    @endphp
                                    @empty
                                    <tr>
                                        <td colspan="3">Tidak ada monitoring yang tersedia.</td>
                                    </tr>
                                    @endforelse
                                </tbody>                                
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>        
        </div>
    </div>
</main>
@endsection