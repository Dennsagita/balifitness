@extends('layouts.app-dashboard')
@section('action')
@section('title', 'Member Materi')
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
                        <!-- aksi batal peminjaman -->
                        <form action="{{ route('tambahmonitoring') }}" method="POST">
                            @csrf
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#batalModal">
                                Tambah 
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="batalModal" tabindex="-1" aria-labelledby="batalModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="batalModalLabel">Form Tambah Data Pelatihan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="link" class="form-label">Link video</label>
                                                <input type="text" class="form-control" id="link" name="link" required>
                                            </div>
                                            <input type="hidden" name="id_log_aktivitas" value="{{ $logaktivitas->id }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Kirim</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>                        
                        <div class="table-responsive">
                            <table class="table datatable table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Link Proses Latihan</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
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
                                        <td>
                                            <form action="{{ route('updatemonitoring', $monitoring->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal-{{ $monitoring->id }}">
                                                    Ubah
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="updateModal-{{ $monitoring->id }}" tabindex="-1" aria-labelledby="updateModalLabel-{{ $monitoring->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="updateModalLabel-{{ $monitoring->id }}">Ubah Informasi</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="link-{{ $monitoring->id }}" class="form-label">Link Video</label>
                                                                    <input type="text" class="form-control" id="link-{{ $monitoring->id }}" name="link" value="{{ $monitoring->link }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Kirim</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>                                        
                                        </td>
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