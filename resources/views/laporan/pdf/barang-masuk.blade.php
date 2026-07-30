<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Barang Masuk</title>

    <style>

        body{
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table,
        th,
        td{
            border:1px solid #000;
        }

        th{
            background:#f2f2f2;
        }

        th,
        td{
            padding:6px;
        }

        .text-right{
            text-align:right;
        }

    </style>

</head>

<body>

    <h2>
        LAPORAN BARANG MASUK
    </h2>

    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>No Masuk</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
                <th>User</th>
            </tr>

        </thead>

        <tbody>

            @php
                $no = 1;
                $grandTotal = 0;
            @endphp

            @forelse($barangMasuks as $masuk)

                @foreach($masuk->details as $detail)

                    @php
                        $grandTotal += $detail->subtotal;
                    @endphp

                    <tr>

                        <td>
                            {{ $no++ }}
                        </td>

                        <td>
                            {{ $masuk->nomor_masuk }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($masuk->tanggal_masuk)->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $detail->barang->nama_barang ?? '-' }}
                        </td>

                        <td>
                            {{ $detail->qty }}
                        </td>

                        <td class="text-right">
                            {{ number_format($detail->harga_beli,0,',','.') }}
                        </td>

                        <td class="text-right">
                            {{ number_format($detail->subtotal,0,',','.') }}
                        </td>

                        <td>
                            {{ $masuk->user->name ?? '-' }}
                        </td>

                    </tr>

                @endforeach

            @empty

                <tr>

                    <td colspan="8" align="center">
                        Tidak ada data barang masuk
                    </td>

                </tr>

            @endforelse

        </tbody>

        <tfoot>

            <tr>

                <th colspan="6" class="text-right">
                    GRAND TOTAL
                </th>

                <th class="text-right">
                    {{ number_format($grandTotal,0,',','.') }}
                </th>

                <th></th>

            </tr>

        </tfoot>

    </table>

</body>

</html>