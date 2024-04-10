@extends('layouts.app-dashboard')
@section('action')
@section('title', 'Data Materi')
@endsection

@section('content')
<!-- Start Page Title -->
<main id="main" class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Data Materi</h1>
                    <br>
                </div>
                <!-- End Page Title -->

                <!-- start JS untuk Validasi -->
                <!-- JS Validasi  -->

                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @elseif(Session::has('delete'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('delete') }}
                </div>
                @elseif(Session::has('editmateri'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('editmateri') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @elseif(Session::has('editkategori'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('editkategori') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @elseif(Session::has('deletemateri'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('deletemateri') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @elseif(Session::has('kategori'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('kategori') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @elseif(Session::has('deletekategori'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('deletekategori') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <!-- End JS Validasi  -->
                <!-- Start Table -->
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title" style="padding-bottom: 1rem;">Data Kategori</h5>

                                    <!-- Button tambah dan cetak data  -->
                                    <a href="{{ route('tambahkategori') }}"><button type="button" class="btn btn-primary"> <i class="bi bi-plus-lg"></i> Tambah Data</button></a> 
                                    <!-- Table with stripped rows -->
                                    <div class="table-responsive">
                                        <table class="table datatable table-hover">
                                            <thead>
                                                <tr>
                                                    <th> No </th>
                                                    <th>Id Materi</th>
                                                    <th>Kategori </th>
                                                    <th style="text-align: center;">Aksi</th>
                                                    <th class="d-none">Tanggal Tambah </th>
                                                    <th  class="d-none">Tanggal Tambah </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $startNumber1 = 1;
                                                @endphp
                                                @foreach($kategori as $data) <!-- Untuk menampilkan database sesuai dengan variabel di controller-->
                                                <tr>
                                                    <td> <p>{{ $startNumber1 }}</p> </td>
                                                    <td>C-{{ \Carbon\Carbon::parse($data->created_at)->format('Ym') }}{{ $data->id }}</td>
                                                    <td>{{ $data->nama}}</td>
                                                    <td  class="d-none">{{ $data->created_at}}</td>
                                                    <td  class="d-none">{{ $data->created_at}}</td>

                                                    <td class="d-flex justify-content-center align-items-center">
                                                        <a href="{{ route('editkategori', ['id' => $data->id]) }}" class="btn btn-primary" style="margin-right: 5px;">
                                                            <i class="bi bi-pencil"></i> Ubah
                                                        </a>
    
                                                        <form action="{{ route('kategori-delete', $data->id) }}" method="POST">
                                                            <button type="button" class="btn btn-danger" style="margin-right: 5px;" data-bs-toggle="modal" data-bs-target="#hapusModal-{{ $data->id }}">
                                                                <i class="bi bi-trash"></i> Hapus
                                                            </button>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="hapusModal-{{ $data->id }}" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="hapusModalLabel">Hapus Coach</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Isi konten modal di sini -->
                                                                            Yakin Ingin hapus Kategori {{ $data->nama }}
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <form action="{{ route('kategori-delete', $data->id) }}" method="POST">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @php
                                                $startNumber1++;
                                                @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- End Table with stripped rows -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                 <!-- Start Table -->
                 <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title" style="padding-bottom: 1rem;">Data Materi</h5>

                                    <!-- Button tambah dan cetak data  -->
                                    <a href="{{ route('tambahmateri') }}"><button type="button" class="btn btn-primary"> <i class="bi bi-plus-lg"></i> Tambah Data</button></a> 
                                    <!-- Table with stripped rows -->
                                    <div class="table-responsive">
                                        <table class="table datatable table-hover">
                                            <thead>
                                                <tr>
                                                    <th> No </th>
                                                    <th>Id Materi</th>
                                                    <th>Kategori </th>
                                                    <th>Nama Coach</th>
                                                    <th>Nama Materi</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $startNumber = 1;
                                                @endphp
                                                @foreach($materi as $data=>$item) <!-- Untuk menampilkan database sesuai dengan variabel di controller-->
                                                <tr>
                                                    <td> <p>{{ $startNumber }}</p> </td>
                                                    <td>C-{{ \Carbon\Carbon::parse($item->created_at)->format('Ym') }}{{ $item->id }}</td>
                                                    <td>{{ $item->kategori->nama}}</td>
                                                    <td>{{ $item->coach->nama }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td class="d-flex align-items-center">
                                                        <a href="{{ route('lihatmateri', ['id' => $item->id]) }}" class="btn btn-warning" style="margin-right: 5px;">
                                                                <i class="bi bi-eye"></i> Lihat
                                                        </a>
                                                        <a href="{{ route('editmateri', ['id' => $item->id]) }}" class="btn btn-primary" style="margin-right: 5px;">
                                                            <i class="bi bi-pencil"></i> Ubah
                                                        </a>
    
                                                        <form action="{{ route('materi-delete', $item->id) }}" method="POST">
                                                            <button type="button" class="btn btn-danger" style="margin-right: 5px;" data-bs-toggle="modal" data-bs-target="#hapusModal-{{ $item->id }}">
                                                                <i class="bi bi-trash"></i> Hapus
                                                            </button>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="hapusModal-{{ $item->id }}" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="hapusModalLabel">Hapus Coach</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Isi konten modal di sini -->
                                                                            Yakin Ingin hapus Materi {{ $item->nama }} Dengan ID: C-{{ \Carbon\Carbon::parse($item->created_at)->format('Ym') }}{{ $item->id }}
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <form action="{{ route('materi-delete', $item->id) }}" method="POST">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                                            </form>
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
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- End Table with stripped rows -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</main>

  
@endsection