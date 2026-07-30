<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok Barang</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th { background: #f2f2f2; }
        th, td { padding: 6px; }
    </style>
</head>
<body>
    <h2>LAPORAN STOK BARANG</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Barang</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Supplier</th>
                <th>Stok</th>
                <th>Stok Minimum</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $item->satuan->nama_satuan ?? '-' }}</td>
                    <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>{{ $item->stok_minimum }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
