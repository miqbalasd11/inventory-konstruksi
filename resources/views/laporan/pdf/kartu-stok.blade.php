<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kartu Stok</title>
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
    <h2>LAPORAN KARTU STOK</h2>

    @if($barangDipilih)
        <p><strong>Barang:</strong> {{ $barangDipilih->nama_barang }}</p>
        <p><strong>Stok Saat Ini:</strong> {{ $barangDipilih->stok }}</p>
    @else
        <p>Tidak ada barang terpilih.</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Referensi</th>
                <th>Jenis</th>
                <th>Masuk</th>
                <th>Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['tanggal'] }}</td>
                    <td>{{ $item['referensi'] }}</td>
                    <td>{{ $item['jenis'] }}</td>
                    <td>{{ $item['masuk'] }}</td>
                    <td>{{ $item['keluar'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
