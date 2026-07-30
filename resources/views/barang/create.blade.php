@extends('layouts.app')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">Tambah Barang</h5>
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

        <form action="{{ route('barang.store') }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Kode Barang
                    </label>

                    <input type="text"
                           name="kode_barang"
                           class="form-control"
                           value="{{ old('kode_barang') }}"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Nama Barang
                    </label>

                    <input type="text"
                           name="nama_barang"
                           class="form-control"
                           value="{{ old('nama_barang') }}"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Kategori
                    </label>

                    <select name="kategori_id"
                            class="form-select"
                            required>

                        <option value="">
                            -- Pilih Kategori --
                        </option>

                        @foreach($kategori as $item)
                            <option value="{{ $item->id }}"
                                {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Satuan
                    </label>

                    <select name="satuan_id"
                            class="form-select"
                            required>

                        <option value="">
                            -- Pilih Satuan --
                        </option>

                        @foreach($satuan as $item)
                            <option value="{{ $item->id }}"
                                {{ old('satuan_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_satuan }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Stok Awal
                    </label>

                    <input type="number"
                           name="stok"
                           class="form-control"
                           value="{{ old('stok', 0) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Stok Minimum
                    </label>

                    <input type="number"
                           name="stok_minimum"
                           class="form-control"
                           value="{{ old('stok_minimum', 0) }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">
                        Keterangan
                    </label>

                    <textarea name="keterangan"
                              rows="4"
                              class="form-control">{{ old('keterangan') }}</textarea>
                </div>

            </div>

            <button type="submit"
                    class="btn btn-primary">
                <i class="bi bi-save"></i>
                Simpan
            </button>

            <a href="{{ route('barang.index') }}"
               class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>

        </form>

    </div>

</div>

@endsection