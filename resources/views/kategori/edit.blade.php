@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        Edit Kategori
    </div>

    <div class="card-body">

        <form action="{{ route('kategori.update', $kategori->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Kode Kategori</label>
                <input type="text"
                       name="kode_kategori"
                       class="form-control"
                       value="{{ $kategori->kode_kategori }}">
            </div>

            <div class="mb-3">
                <label>Nama Kategori</label>
                <input type="text"
                       name="nama_kategori"
                       class="form-control"
                       value="{{ $kategori->nama_kategori }}">
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan"
                          class="form-control">{{ $kategori->keterangan }}</textarea>
            </div>

            <button class="btn btn-warning">
                Update
            </button>

            <a href="{{ route('kategori.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection