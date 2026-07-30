<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Permintaan Barang</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            font-size:12px;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table, th, td{
            border:1px solid black;
        }

        th{
            background:#f2f2f2;
        }

        th, td{
            padding:6px;
        }
    </style>
</head>
<body>

<h2>LAPORAN PERMINTAAN BARANG</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Tanggal</th>
            <th>Barang</th>
            <th>Proyek</th>
            <th>Qty</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>

    @foreach($permintaan as $item)

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->kode_permintaan }}</td>
            <td>{{ $item->tanggal }}</td>
            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
            <td>{{ $item->proyek->nama_proyek ?? '-' }}</td>
            <td>{{ $item->qty }}</td>
            <td>{{ $item->status }}</td>
        </tr>

    @endforeach

    </tbody>

</table>

</body>
</html>