@extends('layouts.app')

@section('title', 'Edit Barang Keluar')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">
                <i class="bi bi-pencil-square me-2"></i>
                Edit Barang Keluar
            </h5>

        </div>

        <div class="card-body">

            <form action="{{ route('barang-keluar.update', $barangKeluar->id) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Tanggal
                    </label>

                    <input type="date"
                        name="tanggal"
                        class="form-control"
                        value="{{ old('tanggal', $barangKeluar->tanggal) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Proyek
                    </label>

                    <select
                        name="proyek_id"
                        class="form-select">

                        @foreach($proyek as $item)

                        <option
                            value="{{ $item->id }}"
                            {{ $barangKeluar->proyek_id == $item->id ? 'selected' : '' }}>

                            {{ $item->nama_proyek }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Barang
                    </label>

                    <select name="barang_id"
                        class="form-select"
                        required>

                        @foreach($barang as $item)

                        <option value="{{ $item->id }}"
                            {{ old('barang_id', $barangKeluar->barang_id) == $item->id ? 'selected' : '' }}>

                            {{ $item->nama_barang }}
                            (Stok : {{ $item->stok }})

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Qty
                    </label>

                    <input type="number"
                        name="qty"
                        class="form-control"
                        min="1"
                        value="{{ old('qty', $barangKeluar->qty) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Keterangan
                    </label>

                    <textarea name="keterangan"
                        class="form-control"
                        rows="3">{{ old('keterangan', $barangKeluar->keterangan) }}</textarea>

                </div>

                <button type="submit"
                    class="btn btn-primary">

                    <i class="bi bi-save"></i>
                    Update

                </button>

                <a href="{{ route('barang-keluar.index') }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection