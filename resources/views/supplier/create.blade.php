@extends('layouts.app')

@section('content')

<div class="card shadow-sm">
    <div class="card-header">
        Tambah supplier
    </div>

    <div class="card-body">

        <form action="{{ route('supplier.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Kode supplier</label>
                <input type="text"
                       name="kode_supplier"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Nama supplier</label>
                <input type="text"
                       name="nama_supplier"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Telepon</label>
                <textarea name="telepon"
                          class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <textarea name="email"
                          class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat"
                          class="form-control"></textarea>
            </div>

            <button class="btn btn-primary">
                Simpan
            </button>

            <a href="{{ route('supplier.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection