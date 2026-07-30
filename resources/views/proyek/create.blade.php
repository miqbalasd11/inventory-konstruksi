@extends('layouts.app')

@section('title', 'Tambah Proyek')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h2 class="fw-bold">

            <i class="fas fa-building me-2"></i>

            Tambah Proyek

        </h2>

        <p class="text-muted">

            Tambahkan proyek konstruksi baru

        </p>

    </div>

    @if ($errors->any())

    <div class="alert alert-danger">

        <ul class="mb-0">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif

    <div class="card shadow border-0 rounded-4">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">

                Data Proyek

            </h5>

        </div>

        <div class="card-body">

            <form action="{{ route('proyek.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Kode Proyek

                        </label>

                        <input
                            type="text"
                            name="kode_proyek"
                            class="form-control"
                            value="{{ old('kode_proyek') }}"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Nama Proyek

                        </label>

                        <input
                            type="text"
                            name="nama_proyek"
                            class="form-control"
                            value="{{ old('nama_proyek') }}"
                            required>

                    </div>

                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Lokasi

                        </label>

                        <textarea
                            name="lokasi"
                            class="form-control"
                            rows="3"
                            required>{{ old('lokasi') }}</textarea>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Tanggal Mulai

                        </label>

                        <input
                            type="date"
                            name="tanggal_mulai"
                            class="form-control"
                            value="{{ old('tanggal_mulai', date('Y-m-d')) }}"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Tanggal Selesai

                        </label>

                        <input
                            type="date"
                            name="tanggal_selesai"
                            class="form-control"
                            value="{{ old('tanggal_selesai') }}">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select"
                            required>

                            <option value="Aktif"
                                {{ old('status') == 'Aktif' ? 'selected' : '' }}>

                                Aktif

                            </option>

                            <option value="Pending"
                                {{ old('status') == 'Pending' ? 'selected' : '' }}>

                                Pending

                            </option>

                            <option value="Selesai"
                                {{ old('status') == 'Selesai' ? 'selected' : '' }}>

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
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-save"></i>

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection