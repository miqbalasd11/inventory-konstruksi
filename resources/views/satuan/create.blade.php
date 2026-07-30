@extends('layouts.app')

@section('content')

<div class="card shadow-sm">
    <div class="card-header">
        Tambah Satuan
    </div>

    <div class="card-body">

        <form action="{{ route('satuan.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Kode Satuan</label>
                <input type="text"
                       name="kode_satuan"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Nama Satuan</label>
                <input type="text"
                       name="nama_satuan"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan"
                          class="form-control"></textarea>
            </div>

            <button class="btn btn-primary">
                Simpan
            </button>

            <a href="{{ route('satuan.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection