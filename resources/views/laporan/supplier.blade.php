@extends('layouts.app')

@section('title','Laporan Supplier')

@section('content')

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header">

            <h5 class="mb-0">
                Laporan Supplier
            </h5>

        </div>

        <div class="card-body">

        <div class="mb-3 d-flex gap-2">
                <a href="{{ route('laporan.supplier.export', request()->query()) }}"
                   class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i>
                    Export Excel
                </a>

                <a href="{{ route('laporan.supplier.pdf', request()->query()) }}"
                   target="_blank"
                   class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i>
                    Export PDF
                </a>
            </div>
            
            <div class="table-responsive">

                <table class="table table-bordered">

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

                        @forelse($suppliers as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item->nama_supplier }}
                            </td>

                            <td>
                                {{ $item->telepon }}
                            </td>

                            <td>
                                {{ $item->email }}
                            </td>

                            <td>
                                {{ $item->alamat }}
                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5"
                                class="text-center">

                                Tidak ada data supplier

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection