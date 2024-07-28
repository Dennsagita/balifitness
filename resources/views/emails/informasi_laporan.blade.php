<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Formulir</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif;">

    <h2>Informasi Dampak Materi Terhadap Berat Badan</h2>
    <table>
        <tr>
            <th>ID Member</th>
            <td>M-{{ \Carbon\Carbon::parse($tanggal)->format('Ym') }}{{ $id_member }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $nama }}</td>
        </tr>
        <tr>
            <th>Pesan Informasi</th>
            <td>{{ $informasi }}</td>
        </tr>
    </table>

    <p style="color: grey;">Email ini dikirim oleh coach {{ $coach }}</p>
    
</body>
</html>
