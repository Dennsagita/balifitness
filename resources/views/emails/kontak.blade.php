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

    <h2>Informasi Pesan Kontak</h2>
    <table>
        <tr>
            <th>Nama</th>
            <td>{{ $kontak['name'] }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $kontak['email'] }}</td>
        </tr>
        <tr>
            <th>Subjek</th>
            <td>{{ $kontak['subject'] }}</td>
        </tr>
        <tr>
            <th>Pesan</th>
            <td>{{ $kontak['message'] }}</td>
        </tr>
    </table>

    <p style="color: grey;">Email ini dikirim melalui formulir kontak.</p>
    
</body>
</html>
