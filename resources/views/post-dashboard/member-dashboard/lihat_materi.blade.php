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
                    Data Berhasil Diedit
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
        </div>
    </div>
</main>

  
@endsection