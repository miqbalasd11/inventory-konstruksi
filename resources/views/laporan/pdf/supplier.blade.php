<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Supplier</title>

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

<h2>LAPORAN DATA SUPPLIER</h2>

<table>

    <thead>

        <tr>
            <th>No</th>
            <th>Nama Supplier</th>
            <th>Telepon</th>
            <th>Email</th>
            <th>Alamat</th>
        </tr>

    </thead>

    <tbody>

    @foreach($suppliers as $item)

    <tr>

        <td>
            {{ $loop->iteration }}
        </td>

        <td>
            {{ $item->nama_supplier }}
        </td>

        <td>
            {{ $item->telepon ?? '-' }}
        </td>

        <td>
            {{ $item->email ?? '-' }}
        </td>

        <td>
            {{ $item->alamat ?? '-' }}
        </td>

    </tr>

    @endforeach

    </tbody>

</table>

</body>
</html>