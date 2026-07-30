@extends('layouts.app')

@section('title', 'Edit Permintaan Barang')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header">
            Edit Permintaan Barang
        </div>

        <div class="card-body">

            <form action="{{ route('permintaan-barang.update', $permintaanBarang->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Kode Permintaan
                        </label>

                        <input type="text"
                               class="form-control"
                               value="{{ $permintaanBarang->kode_permintaan }}"
                               readonly>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Tanggal
                        </label>

                        <input type="date"
                               name="tanggal"
                               class="form-control"
                               value="{{ old('tanggal', $permintaanBarang->tanggal?->format('Y-m-d')) }}"
                               required>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <input type="text"
                               class="form-control"
                               value="{{ $permintaanBarang->status }}"
                               readonly>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Barang
                        </label>

                        <select name="barang_id"
                                class="form-control"
                                required>

                            <option value="">
                                Pilih Barang
                            </option>

                            @foreach($barang as $item)

                                <option value="{{ $item->id }}"
                                    {{ $permintaanBarang->barang_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_barang }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Proyek
                        </label>

                        <select name="proyek_id"
                                class="form-control"
                                required>

                            <option value="">
                                Pilih Proyek
                            </option>

                            @foreach($proyek as $item)

                                <option value="{{ $item->id }}"
                                    {{ $permintaanBarang->proyek_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_proyek }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Qty
                        </label>

                        <input type="number"
                               name="qty"
                               class="form-control"
                               min="1"
                               value="{{ old('qty', $permintaanBarang->qty) }}"
                               required>

                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Keterangan
                    </label>

                    <textarea name="keterangan"
                              rows="4"
                              class="form-control">{{ old('keterangan', $permintaanBarang->keterangan) }}</textarea>

                </div>

                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">

                        Update

                    </button>

                    <a href="{{ route('permintaan-barang.index') }}"
                       class="btn btn-secondary">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection