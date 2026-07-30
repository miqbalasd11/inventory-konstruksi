<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Purchase Order</title>

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

<h2>LAPORAN PURCHASE ORDER</h2>

<table>

    <thead>

        <tr>
            <th>No</th>
            <th>Nomor PO</th>
            <th>Nomor MR</th>
            <th>Supplier</th>
            <th>Tanggal PO</th>
            <th>Status</th>
            <th>Total</th>
        </tr>

    </thead>

    <tbody>

    @foreach($purchaseOrders as $item)

    <tr>

        <td>
            {{ $loop->iteration }}
        </td>

        <td>
            {{ $item->nomor_po }}
        </td>

        <td>
            {{ $item->materialRequest->nomor_mr ?? '-' }}
        </td>

        <td>
            {{ $item->supplier->nama_supplier ?? '-' }}
        </td>

        <td>
            {{ $item->tanggal_po }}
        </td>

        <td>
            {{ $item->status }}
        </td>

        <td>
            Rp {{ number_format($item->total,0,',','.') }}
        </td>

    </tr>

    @endforeach

    </tbody>

</table>

</body>
</html>