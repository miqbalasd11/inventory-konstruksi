@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        Tambah Kategori
    </div>

    <div class="card-body">

        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Kode Kategori</label>
                <input type="text"
                       name="kode_kategori"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Nama Kategori</label>
                <input type="text"
                       name="nama_kategori"
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

            <a href="{{ route('kategori.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection