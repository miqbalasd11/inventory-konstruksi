@extends('layouts.app')

@section('title','Ajukan Permintaan')

@section('content')

<div class="container-fluid">

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">
            <h5 class="mb-0">
                Ajukan Permintaan Material
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('permintaan-barang.store') }}"
                method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Tanggal</label>
                        <input type="date"
                            name="tanggal"
                            class="form-control"
                            value="{{ date('Y-m-d') }}"
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Proyek</label>
                        <select name="proyek_id"
                            class="form-select"
                            required>

                            <option value="">
                                -- Pilih Proyek --
                            </option>

                            @foreach($proyek as $item)

                            <option value="{{ $item->id }}">
                                {{ $item->nama_proyek }}
                            </option>

                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Barang</label>

                        <select name="barang_id"
                            class="form-select"
                            required>

                            <option value="">
                                -- Pilih Barang --
                            </option>

                            @foreach($barang as $item)

                            <option value="{{ $item->id }}">
                                {{ $item->nama_barang }}
                            </option>

                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Qty</label>

                        <input type="number"
                            name="qty"
                            class="form-control"
                            min="1"
                            required>
                    </div>

                    <div class="col-12 mb-3">
                        <label>Keterangan</label>

                        <textarea
                            name="keterangan"
                            class="form-control"
                            rows="3"></textarea>
                    </div>

                </div>

                <button
                    class="btn btn-primary">

                    Simpan Permintaan

                </button>

            </form>

        </div>

    </div>

</div>

@endsection