@extends('layouts.app')

@section('content')

<div class="card shadow-sm">
    <div class="card-header">
        Edit Satuan
    </div>

    <div class="card-body">

        <form action="{{ route('satuan.update',$satuan->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Kode Satuan</label>
                <input type="text"
                       name="kode_satuan"
                       class="form-control"
                       value="{{ $satuan->kode_satuan }}">
            </div>

            <div class="mb-3">
                <label>Nama Satuan</label>
                <input type="text"
                       name="nama_satuan"
                       class="form-control"
                       value="{{ $satuan->nama_satuan }}">
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan"
                          class="form-control">{{ $satuan->keterangan }}</textarea>
            </div>

            <button class="btn btn-warning">
                Update
            </button>

            <a href="{{ route('satuan.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection