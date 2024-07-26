@extends('layouts.app-dashboard')
@section('action')
@section('title', 'Dashboar Coach')
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
                                        {{-- <th>Aksi</th> --}}
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
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Grafik Aktivitas Materi Coach {{ $coach->nama }}</h5>
                
                        <!-- Bar Chart -->
                        <canvas id="barChart" style="max-height: 400px;"></canvas>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                // Data dari controller yang diteruskan ke view
                                var logAktivitasData = @json($logAktivitasData);
                
                                var labels = logAktivitasData.map(item => item.nama);
                                var data = logAktivitasData.map(item => item.total);
                                
                                var backgroundColors = labels.map((_, index) => `rgba(${(index*50)%255}, ${(index*80)%255}, ${(index*100)%255}, 0.2)`);
                                var borderColors = labels.map((_, index) => `rgba(${(index*50)%255}, ${(index*80)%255}, ${(index*100)%255}, 1)`);
                
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
        window.location.href = '{{ route('lapmatericoach', ['tahun' => 'tahun_value', 'bulan' => 'bulan_value', 'materi' => 'materi_value']) }}'
            .replace('tahun_value', tahun)
            .replace('bulan_value', bulan)
            .replace('materi_value', materi);
    });
  </script>  
@endsection