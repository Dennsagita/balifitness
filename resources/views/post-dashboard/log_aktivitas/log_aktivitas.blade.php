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
                    <h1>Data Log Aktivitas</h1>
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
                        <h5 class="card-title" style="padding-bottom: 1rem;">Log Aktivitas</h5>

                        <div class="container mb-2">
                            <form id="filterForm">
                              <div class="row">
                                  <div class="col-md-2 col-sm-6">
                                      <label for="bulan" class="form-label">Bulan:</label>
                                      <select name="bulan" id="bulan" class="form-select">
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                  </div>
                                  <div class="col-md-2 col-sm-6">
                                      <label for="tahun" class="form-label">Tahun:</label>
                                      <input type="text" name="tahun" id="tahun" required pattern="[0-9]{4}" placeholder="(contoh: 2022)" class="form-control">
                                  </div>
                                  <div class="col-md-2 col-sm-6">
                                    <label for="status" class="form-label">Materi:</label>
                                    <select name="materi" id="materi" class="form-select">
                                        @foreach($materi as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                  <div class="col-md-2 col-sm-12 mt-4">
                                      <button class="btn btn-primary mt-md-2" type="submit">Cetak</button>
                                  </div>
                              </div>
                            </form>
                      </div>
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
                                        <th>Berat Badan Saat Ini</th>
                                        <th>Target Berat Badan</th>
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
                                        <td>{{ $log->member->berat_badan_sekarang }} KG</td>
                                        <td>{{ $log->member->target_berat_badan }} KG</td>
                                            <td class="align-items-center">
                                                <a href="{{ route('lihatlogaktivitasadmin', ['logaktivitasid' => $log->id]) }}" class="btn btn-warning" >
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
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Grafik Aktivitas Materi</h5>
                    
                            <!-- Bar Chart -->
                            <canvas id="barChart" style="max-height: 400px;"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                var logAktivitasData = @json($logAktivitasData);

                                var labels = logAktivitasData.map(item => item.nama);
                                var data = logAktivitasData.map(item => item.total);
                                var coaches = logAktivitasData.map(item => item.coach);

                                var backgroundColors = [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',
                                    'rgba(255, 205, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(201, 203, 207, 0.2)'
                                ];

                                var borderColors = [
                                    'rgb(255, 99, 132)',
                                    'rgb(255, 159, 64)',
                                    'rgb(255, 205, 86)',
                                    'rgb(75, 192, 192)',
                                    'rgb(54, 162, 235)',
                                    'rgb(153, 102, 255)',
                                    'rgb(201, 203, 207)'
                                ];

                                new Chart(document.querySelector('#barChart'), {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Jumlah Aktivitas per Materi',
                                            data: data,
                                            backgroundColor: backgroundColors,
                                            borderColor: borderColors,
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        },
                                        plugins: {
                                            tooltip: {
                                                callbacks: {
                                                    title: function(tooltipItems) {
                                                        var index = tooltipItems[0].dataIndex;
                                                        return labels[index] + ' (Coach: ' + coaches[index] + ')';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            });

                            </script>
                            <!-- End Bar Chart -->
                    
                        </div>
                    </div>                    
                </div>                            
            </div>
        </div>
    </div>
</main>
<!-- Tambahkan script JavaScript -->
<script>
    // Tangkap elemen form
    const filterForm = document.getElementById('filterForm');
  
    // Tangkap elemen select bulan, tahun, dan status
    const bulanSelect = document.getElementById('bulan');
    const tahunInput = document.getElementById('tahun');
    const materiSelect = document.getElementById('materi');
  
    // Tambahkan event listener untuk mengirimkan permintaan cetak laporan
    filterForm.addEventListener('submit', function(event) {
        event.preventDefault();
  
        // Ambil nilai bulan, tahun, dan status yang dipilih
        const bulan = bulanSelect.value;
        const tahun = tahunInput.value;
        const materi = materiSelect.value;
  
        // Kirim permintaan cetak laporan dengan parameter bulan, tahun, dan materi
        window.location.href = '{{ route('lihatlapmateri', ['tahun' => 'tahun_value', 'bulan' => 'bulan_value', 'materi' => 'materi_value']) }}'
            .replace('tahun_value', tahun)
            .replace('bulan_value', bulan)
            .replace('materi_value', materi);
    });
  </script>  
@endsection