@extends('layouts.app')

@section('title','Edit Proyek')

@section('content')

<div class="container-fluid">

<div class="mb-4">
    <h2 class="fw-bold">Edit Proyek</h2>
</div>

<div class="card shadow border-0 rounded-4">

    <div class="card-header bg-warning">
        <h5 class="mb-0">
            Edit Data Proyek
        </h5>
    </div>

    <div class="card-body">

        <form
            action="{{ route('proyek.update',$proyek->id) }}"
            method="POST">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Kode Proyek</label>
                    <input
                        type="text"
                        name="kode_proyek"
                        value="{{ $proyek->kode_proyek }}"
                        class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Nama Proyek</label>
                    <input
                        type="text"
                        name="nama_proyek"
                        value="{{ $proyek->nama_proyek }}"
                        class="form-control">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Lokasi</label>
                    <textarea
                        name="lokasi"
                        class="form-control"
                        rows="3">{{ $proyek->lokasi }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tanggal Mulai</label>
                    <input
                        type="date"
                        name="tanggal_mulai"
                        value="{{ $proyek->tanggal_mulai }}"
                        class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tanggal Selesai</label>
                    <input
                        type="date"
                        name="tanggal_selesai"
                        value="{{ $proyek->tanggal_selesai }}"
                        class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status</label>

                    <select
                        name="status"
                        class="form-control">

                        <option value="Aktif"
                        {{ $proyek->status=='Aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="Pending"
                        {{ $proyek->status=='Pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="Selesai"
                        {{ $proyek->status=='Selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>

                    </select>

                </div>

            </div>

            <div class="text-end">

                <a href="{{ route('proyek.index') }}"
                    class="btn btn-secondary">
                    Kembali
                </a>

                <button
                    class="btn btn-warning">
                    Update
                </button>

            </div>

        </form>

    </div>

</div>

</div>
@endsection
