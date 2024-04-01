@extends('layouts.app-dashboard')
@section('action')
@section('title', 'Data Coach')
@endsection

@section('content')
<!-- Start Page Title -->
<main id="main" class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Data Coach</h1>
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
                    Data Berhasil Diedit
                </div>
                @endif
                <!-- End JS Validasi  -->

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="padding-bottom: 1rem;">Data Coach</h5>

                        <!-- Button tambah dan cetak data  -->
                        <a href="{{ route('tambahcoach') }}"><button type="button" class="btn btn-primary"> <i class="bi bi-plus-lg"></i> Tambah Data</button></a> 
                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table datatable table-hover">
                                <thead>
                                    <tr>
                                        <th> No </th>
                                        <th>Id Coach</th>
                                        <th>Nama </th>
                                        <th>email</th>
                                        <th>No Telphone</th>
                                        <th>Alamat</th>
                                        <th>Tanggal Registrasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $startNumber = 1;
                                    @endphp
                                    @foreach($coaches as $data=>$item) <!-- Untuk menampilkan database sesuai dengan variabel di controller-->
                                    <tr>
                                        <td> <p>{{ $startNumber }}</p> </td>
                                        <td>C-{{ \Carbon\Carbon::parse($item->created_at)->format('Ym') }}{{ $item->id }}</td>
                                        <td>{{ $item->nama}}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->no_telp }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                        <td class="d-flex align-items-center mt-4">
                                            <form action="{{ route('coach.delete', $item->id) }}" method="POST">
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
                                                                Yakin Ingin hapus Coach ID: C-{{ \Carbon\Carbon::parse($item->created_at)->format('Ym') }}{{ $item->id }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <form action="{{ route('coach.delete', $item->id) }}" method="POST">
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
    </div>
</main>

  
@endsection