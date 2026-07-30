@extends('layouts.app')

@section('title', 'Laporan Stok Barang')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="mb-1 fw-bold">
                        Laporan Stok Barang
                    </h4>

                    <small class="text-muted">
                        Rekap stok barang saat ini, termasuk status ketersediaan berdasarkan stok minimum
                    </small>
                </div>

                <div class="d-flex gap-2">

                <a href="{{ route('laporan.stok.export') }}"
                    class="btn btn-success">

                    <i class="bi bi-file-earmark-excel"></i>
                    Export Excel
                </a>

                <a href="{{ route('laporan.stok.pdf') }}" target="_blank"
                    class="btn btn-danger">

                    <i class="bi bi-file-earmark-pdf-fill"></i>
                    PDF

                </a>

            </div>

            </div>

        </div>

        <div class="card-body">

            <div id="print-area" class="table-responsive">

                <table class="table table-bordered table-striped"
                    id="tableLaporan">

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
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($barang as $item)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $item->kode_barang }}</td>

                            <td>{{ $item->nama_barang }}</td>

                            <td>{{ $item->kategori->nama_kategori }}</td>

                            <td>{{ $item->satuan->nama_satuan }}</td>

                            <td>{{ $item->supplier->nama_supplier }}</td>

                            <td>{{ $item->stok }}</td>

                            <td>{{ $item->stok_minimum }}</td>

                            <td>

                                @if($item->stok <= $item->stok_minimum)

                                    <span class="badge bg-danger">
                                        Stok Menipis
                                    </span>

                                    @else

                                    <span class="badge bg-success">
                                        Aman
                                    </span>

                                    @endif

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>
    $(document).ready(function() {

        $('#tableLaporan').DataTable({
            responsive: true,
            autoWidth: false
        });

    });

    function printTable() {
        let content =
            document.getElementById('print-area').innerHTML;

        let printWindow =
            window.open('', '', 'width=1000,height=700');

        printWindow.document.write(`
        <html>
        <head>

            <title>Laporan Stok Barang</title>

            <style>

                body{
                    font-family:Arial,sans-serif;
                    padding:20px;
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

                th,td{
                    padding:8px;
                    text-align:left;
                }

                th{
                    background:#f0f0f0;
                }

            </style>

        </head>

        <body>

            <h2>
                LAPORAN STOK BARANG
            </h2>

            ${content}

        </body>

        </html>
    `);

        printWindow.document.close();

        printWindow.print();
    }
</script>

@endpush