<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Material Proyek</title>
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
    <h2>LAPORAN MATERIAL PROYEK</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Proyek</th>
                <th>Barang</th>
                <th>Total Pakai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ optional($item->proyek)->nama_proyek ?? '-' }}</td>
                    <td>{{ optional($item->barang)->nama_barang ?? '-' }}</td>
                    <td>{{ $item->total_pakai }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
