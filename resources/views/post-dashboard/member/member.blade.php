@extends('layouts.app-dashboard')
@section('action')
@section('title', 'Data Member')
@endsection

@section('content')
<!-- Start Page Title -->
<main id="main" class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Data Member</h1>
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
                    {{ Session::get('delete') }}
                </div>
                @elseif(Session::has('edit'))
                <div class="alert alert-success" role="alert">
                    Data Berhasil Diedit
                </div>
                @endif
                <!-- End JS Validasi  -->

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="padding-bottom: 1rem;">Data Member</h5>

                        <!-- Button tambah dan cetak data  -->
                        {{-- <a href="{{ route('tambahcoach') }}"><button type="button" class="btn btn-primary"> <i class="bi bi-plus-lg"></i> Tambah Data</button></a>  --}}
                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table datatable table-hover">
                                <thead>
                                    <tr>
                                        <th> No </th>
                                        <th>Id Member</th>
                                        <th>Nama </th>
                                        <th>email</th>
                                        <th>Nomot Telphone</th>
                                        <th>Alamat</th>
                                        <th>Foto</th>
                                        <th>Tanggal Registrasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $startNumber = 1;
                                    @endphp
                                    @foreach($member as $data=>$item) <!-- Untuk menampilkan database sesuai dengan variabel di controller-->
                                    <tr>
                                        <td> <p>{{ $startNumber }}</p> </td>
                                        <td>M-{{ \Carbon\Carbon::parse($item->created_at)->format('Ym') }}{{ $item->id }}</td>
                                        <td>{{ $item->nama}}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->no_telp }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>
                                            @if($item->images && $item->images->count())
                                            <img class="featured-img img-fluid rounded" src="{{ asset('storage/' . $item->images->src) }}" alt="{{ $item->nama }}" style="width: 100px; height: 100px;">
                                            @else
                                            <img class="featured-img img-fluid rounded" src="{{ asset('assets/img/profilekosong.jpg') }}" alt="{{ $item->nama }}" style="width: 100px; height: 100px;">
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                        <td class="align-items-center">
                                            <form action="{{ route('member.delete', $item->id) }}" method="POST">
                                                <button type="button" class="btn btn-danger" style="margin-right: 5px;" data-bs-toggle="modal" data-bs-target="#hapusModal-{{ $item->id }}">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="hapusModal-{{ $item->id }}" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="hapusModalLabel">Hapus Member</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Isi konten modal di sini -->
                                                                Yakin Ingin hapus Member ID: M-{{ \Carbon\Carbon::parse($item->created_at)->format('Ym') }}{{ $item->id }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <form action="{{ route('member.delete', $item->id) }}" method="POST">
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