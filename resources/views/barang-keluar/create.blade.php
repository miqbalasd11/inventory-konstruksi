@extends('layouts.app')

@section('title', 'Tambah Barang Keluar')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">
                <i class="bi bi-plus-circle me-2"></i>
                Tambah Barang Keluar
            </h5>

        </div>

        <div class="card-body">

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form
                action="{{ route('barang-keluar.store') }}"
                method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Tanggal Keluar
                        </label>

                        <input
                            type="date"
                            name="tanggal_keluar"
                            class="form-control"
                            value="{{ old('tanggal_keluar', date('Y-m-d')) }}"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Proyek
                        </label>

                        <select
                            name="proyek_id"
                            class="form-select"
                            required>

                            <option value="">
                                -- Pilih Proyek --
                            </option>

                            @foreach($proyeks as $proyek)

                                <option
                                    value="{{ $proyek->id }}">

                                    {{ $proyek->kode_proyek }}
                                    -
                                    {{ $proyek->nama_proyek }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Keterangan
                    </label>

                    <textarea
                        name="keterangan"
                        class="form-control"
                        rows="3">{{ old('keterangan') }}</textarea>

                </div>

                <hr>

                <h6 class="fw-bold mb-3">

                    Detail Barang

                </h6>

                <table
                    class="table table-bordered mb-3"
                    id="tableBarang">

                    <thead>

                        <tr>

                            <th width="55%">
                                Barang
                            </th>

                            <th width="20%">
                                Qty
                            </th>

                            <th width="10%">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>

                                <select
                                    name="barang_id[]"
                                    class="form-select"
                                    required>

                                    <option value="">
                                        Pilih Barang
                                    </option>

                                    @foreach($barangs as $barang)

                                        <option
                                            value="{{ $barang->id }}">

                                            {{ $barang->nama_barang }}
                                            (Stok :
                                            {{ $barang->stok }})

                                        </option>

                                    @endforeach

                                </select>

                            </td>

                            <td>

                                <input
                                    type="number"
                                    name="qty[]"
                                    class="form-control"
                                    min="1"
                                    required>

                            </td>

                            <td class="text-center">

                                <button
                                    type="button"
                                    class="btn btn-success btn-sm"
                                    id="addRow">

                                    <i class="bi bi-plus"></i>

                                </button>

                            </td>

                        </tr>

                    </tbody>

                </table>

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="bi bi-save"></i>
                    Simpan

                </button>

                <a
                    href="{{ route('barang-keluar.index') }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

$(document).ready(function () {

    $('#addRow').click(function () {

        let row = `
        <tr>

            <td>

                <select
                    name="barang_id[]"
                    class="form-select"
                    required>

                    <option value="">
                        Pilih Barang
                    </option>

                    @foreach($barangs as $barang)

                    <option value="{{ $barang->id }}">

                        {{ $barang->nama_barang }}
                        (Stok : {{ $barang->stok }})

                    </option>

                    @endforeach

                </select>

            </td>

            <td>

                <input
                    type="number"
                    name="qty[]"
                    class="form-control"
                    min="1"
                    required>

            </td>

            <td class="text-center">

                <button
                    type="button"
                    class="btn btn-danger btn-sm removeRow">

                    <i class="bi bi-trash"></i>

                </button>

            </td>

        </tr>
        `;

        $('#tableBarang tbody').append(row);

    });

    $(document).on(
        'click',
        '.removeRow',
        function () {

            $(this)
                .closest('tr')
                .remove();

        }
    );

});

</script>

@endpush