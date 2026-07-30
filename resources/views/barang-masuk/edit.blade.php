@extends('layouts.app')

@section('title', 'Edit Barang Masuk')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">
                <i class="bi bi-pencil-square me-2"></i>
                Edit Barang Masuk
            </h5>

        </div>

        <div class="card-body">

            <form action="{{ route('barang-masuk.update', $barangMasuk->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Tanggal
                    </label>

                    <input type="date"
                           name="tanggal_masuk"
                           class="form-control"
                           value="{{ old('tanggal', $barangMasuk->tanggal) }}"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Barang
                    </label>

                    <select name="barang_id"
                            class="form-select"
                            required>

                        @foreach($barangs as $item)

                        <option value="{{ $item->id }}"
                            {{ old('barang_id', $barangMasuk->barang_id) == $item->id ? 'selected' : '' }}>

                            {{ $item->nama_barang }}

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
                           id="qty"
                           class="form-control"
                           min="1"
                           value="{{ old('qty', $barangMasuk->qty) }}"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Harga
                    </label>

                    <input type="number"
                           name="harga"
                           id="harga"
                           class="form-control"
                           min="0"
                           value="{{ old('harga', $barangMasuk->harga) }}"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Total
                    </label>

                    <input type="text"
                           id="total"
                           class="form-control"
                           readonly>

                </div>

                <button type="submit"
                        class="btn btn-primary">

                    <i class="bi bi-save"></i>
                    Update

                </button>

                <a href="{{ route('barang-masuk.index') }}"
                   class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

function hitungTotal() {

    let qty = parseFloat($('#qty').val()) || 0;
    let harga = parseFloat($('#harga').val()) || 0;

    let total = qty * harga;

    $('#total').val(
        'Rp ' + total.toLocaleString('id-ID')
    );
}

$('#qty').on('keyup change', hitungTotal);
$('#harga').on('keyup change', hitungTotal);

hitungTotal();

</script>

@endpush