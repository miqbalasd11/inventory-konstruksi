@extends('layouts.app')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">Edit Barang</h5>
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

        <form action="{{ route('barang.update', $barang->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Nama Barang
                    </label>

                    <input type="text"
                           name="nama_barang"
                           class="form-control"
                           value="{{ old('nama_barang', $barang->nama_barang) }}"
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
                                {{ old('kategori_id', $barang->kategori_id) == $item->id ? 'selected' : '' }}>
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
                                {{ old('satuan_id', $barang->satuan_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_satuan }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Stok
                    </label>

                    <input type="number"
                           name="stok"
                           class="form-control"
                           value="{{ old('stok', $barang->stok) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Stok Minimum
                    </label>

                    <input type="number"
                           name="stok_minimum"
                           class="form-control"
                           value="{{ old('stok_minimum', $barang->stok_minimum) }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">
                        Keterangan
                    </label>

                    <textarea name="keterangan"
                              rows="4"
                              class="form-control">{{ old('keterangan', $barang->keterangan) }}</textarea>
                </div>

            </div>

            <button type="submit"
                    class="btn btn-warning">
                <i class="bi bi-pencil-square"></i>
                Update
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