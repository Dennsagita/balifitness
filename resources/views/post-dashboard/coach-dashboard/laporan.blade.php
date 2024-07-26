<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Laporan</title>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Tambahkan link untuk Font Awesome -->
    <style>
        @page {
            size: portrait; /* Atur ukuran halaman A4 potrait */
        }
        body {
            font-family: Arial, sans-serif;
            text-align: center; /* Tengahkan teks */
        }
        .print-button {
            display: block; /* Atur agar tombol cetak muncul sebagai blok */
            margin: 20px auto; /* Atur jarak margin di atas dan bawah serta tengahkan */
        }
        .container {
            max-width: 960px;
            margin: 0 auto; /* Mengatur margin secara otomatis untuk memposisikan elemen di tengah */
            padding: 20px;
        }
        table {
        width: 100%;
        border-collapse: collapse;
        margin-left: auto; /* Mengatur margin kiri menjadi otomatis */
        margin-right: auto; /* Mengatur margin kanan menjadi otomatis */
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 6px;
            font-size: 10pt; /* Ukuran font di dalam tabel */
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .header {
            text-align: center; /* Tengahkan teks */
            margin-bottom: 20px;
        }
        .header h1, .header h2, .header h3, .header h4, .header h5, .header h6 {
            margin: 0;
        }
        .garis {
            border: 1px solid #000;
            margin-bottom: 20px;
        }
        .signature {
            text-align: right; /* Untuk membuat teks di kanan */
            height: 100%; /* Memberi tinggi agar flexbox berfungsi dengan baik */
            display: flex; /* Menggunakan flexbox */
            justify-content: flex-end; /* Mengatur konten agar berada di ujung kanan */
            align-items: center; /* Mengatur penempatan vertikal ke tengah */
        }

        .align-middle {
            display: flex; /* Menggunakan flexbox */
            flex-direction: column; /* Menjadikan elemen anak menjadi kolom */
        }

        .signature p {
            margin: 0; /* Menghapus margin agar teks tidak memiliki ruang tambahan */
        }

        .align-middle > div {
            text-align: center; /* Mengatur teks di tengah secara horizontal */
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- @php
            $downloaded = isset($_GET['download']); // Periksa apakah data sudah diunduh
        @endphp
        @unless($downloaded) <!-- Tampilkan tombol cetak jika data belum diunduh -->
        <a href="{{ route('cetakpeminjaman', ['tahun' => $tanggal->year, 'bulan' => $tanggal->month, 'status' => $status, 'download' => 1]) }}" style="position: absolute; top: 20px; right: 20px;">
            <button class="btn btn-primary" type="button"><i class="fas fa-print"></i> Cetak</button>
        </a>
        
        @endunless --}}
        
            <h2 style="font-size: 16pt;">BALI FITNESS SEMINYAK</h2>
            <h3 style="font-size: 12pt;">Jl. Sunset Road No.333, Seminyak, Kec. Kuta, Kabupaten Badung, Bali 80361</h3>
      
        <div class="garis"></div>
        <div class="text-center mb-3">
            <h4>Laporan Exercise Materi</h4>
            <h5>Coach {{ $coach->nama }}</h5>
        </div>
        <table>
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Member</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Nama Materi</th>
                    <th scope="col">Materi Coach</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Tanggal Pilih</th>
                    <th scope="col">Berat Badan Saat Ini</th>
                    <th scope="col">Target Berat Badan</th>
                </tr>
            </thead>
            <tbody>
                <!-- Isi tabel data peminjamanbatal -->
                @foreach($logaktivitas as $key => $data)
                <tr>
                    <td>{{ $startNumber + $key }}</td>
                    <td>{{ $data->member->nama }}</td>
                    <td>{{ $data->materi->kategori->nama }}</td>
                    <td>{{ $data->materi->nama }}</td>
                    <td>{{ $data->materi->coach->nama }}</td>
                    <td>{{ $data->deskripsi }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}</td>
                    <td>{{ $data->member->berat_badan_sekarang }}</td>
                    <td>{{ $data->member->target_berat_badan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
         <!-- Kolom tanda tangan -->
         {{-- <div class="signature">
            <div class="align-middle">
                <div>
                    <br>
                    <br>
                    <br>
                    <p>Denpasar, <span id="currentDate"></span></p>
                </div>
                <div>
                    <p class="signature-position">Kelian Banjar,</p>
                </div>
                <br>
                <br>
                <br>
                <br>
                <div>
                    <p class="signature-position">I Ketut Sumerta</p>
                </div>
            </div>
        </div> --}}
    </div>
    <script>
        var today = new Date();
        var date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
        document.getElementById('currentDate').innerHTML = date;
    </script>
    <script>
        window.onload = function() {
            window.print(); // Memanggil fungsi cetak saat halaman dimuat
        };
    </script>  
</body>
</html>
