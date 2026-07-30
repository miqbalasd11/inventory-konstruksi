@extends('layouts.app')

@section('title', 'Barang Masuk')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                <i class="bi bi-box-arrow-in-down me-2"></i>
                Data Barang Masuk
            </h5>

            <a href="{{ route('barang-masuk.create') }}"
                class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Tambah Data
            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped"
                    id="tableBarangMasuk">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Masuk</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Jumlah Item</th>
                            <th>User</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($barangMasuks as $item)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $item->kode_masuk }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $item->supplier?->nama_supplier ?? '-' }}
                            </td>

                            <td>
                                {{ $item->details->count() }}
                            </td>

                            <td>
                                {{ $item->user?->name }}
                            </td>

                            <td>

                                <a href="{{ route('barang-masuk.show', $item->id) }}"
                                    class="btn btn-info btn-sm"
                                    title="Detail">

                                    <i class="bi bi-eye"></i>

                                </a>

                                <!-- <a href="{{ route('barang-masuk.edit', $item->id) }}"
                                    class="btn btn-warning btn-sm"
                                    title="Edit">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <form action="{{ route('barang-masuk.destroy', $item->id) }}"
                                    method="POST"
                                    class="d-inline form-delete">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        title="Hapus">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form> -->

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