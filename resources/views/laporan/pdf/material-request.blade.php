<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Material Request</title>

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

        table,th,td{
            border:1px solid #000;
        }

        th{
            background:#f2f2f2;
        }

        th,td{
            padding:6px;
        }

    </style>

</head>
<body>

<h2>LAPORAN MATERIAL REQUEST</h2>

<table>

    <thead>

        <tr>
            <th>No</th>
            <th>Nomor MR</th>
            <th>Tanggal</th>
            <th>Barang</th>
            <th>Qty</th>
            <th>Status</th>
            <th>User</th>
        </tr>

    </thead>

    <tbody>

    @php $no = 1; @endphp

    @foreach($materialRequests as $mr)

        @foreach($mr->details as $detail)

        <tr>

            <td>{{ $no++ }}</td>

            <td>
                {{ $mr->nomor_mr }}
            </td>

            <td>
                {{ $mr->tanggal_request }}
            </td>

            <td>
                {{ $detail->barang->nama_barang ?? '-' }}
            </td>

            <td>
                {{ $detail->qty }}
            </td>

            <td>
                {{ ucfirst($mr->status) }}
            </td>

            <td>
                {{ $mr->user->name ?? '-' }}
            </td>

        </tr>

        @endforeach

    @endforeach

    </tbody>

</table>

</body>
</html>