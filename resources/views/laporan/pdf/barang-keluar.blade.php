<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Barang Keluar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            background: #f2f2f2;
        }

        th,
        td {
            padding: 6px;
        }
    </style>
</head>

<body>
    <h2>LAPORAN BARANG KELUAR</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Qty</th>
                <th>Keterangan</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangKeluar as $keluar)

            @foreach($keluar->details as $detail)

            <tr>
                <td>{{ $loop->parent->iteration }}</td>

                <td>
                    {{ \Carbon\Carbon::parse($keluar->tanggal_keluar)->format('d-m-Y') }}
                </td>

                <td>
                    {{ $detail->barang->nama_barang ?? '-' }}
                </td>

                <td>
                    {{ $detail->qty }}
                </td>

                <td>
                    {{ $keluar->keterangan ?? '-' }}
                </td>

                <td>
                    {{ $keluar->user->name ?? '-' }}
                </td>

            </tr>

            @endforeach

            @endforeach
        </tbody>
    </table>
</body>

</html>