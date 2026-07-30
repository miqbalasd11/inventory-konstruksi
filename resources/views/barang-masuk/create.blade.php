@extends('layouts.app')

@section('title', 'Tambah Barang Masuk')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-plus-circle me-2"></i>
                Tambah Barang Masuk
            </h5>
        </div>

        <div class="card-body">

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('barang-masuk.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Tanggal Masuk
                        </label>

                        <input type="date"
                               name="tanggal_masuk"
                               class="form-control"
                               value="{{ old('tanggal_masuk', date('Y-m-d')) }}"
                               required>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Supplier
                        </label>

                        <select name="supplier_id"
                                class="form-select">

                            <option value="">
                                -- Pilih Supplier --
                            </option>

                            @foreach($suppliers as $supplier)

                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>

                                    {{ $supplier->nama_supplier }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Purchase Order
                        </label>

                        <select name="purchase_order_id"
                                class="form-select">

                            <option value="">
                                -- Pilih PO --
                            </option>

                            @foreach($purchaseOrders as $po)

                                <option value="{{ $po->id }}"
                                    {{ old('purchase_order_id') == $po->id ? 'selected' : '' }}>

                                    {{ $po->nomor_po }}

                                    @if($po->status)
                                        ({{ $po->status }})
                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <hr>

                <h6 class="fw-bold mb-3">
                    Detail Barang
                </h6>

                <div class="table-responsive">

                    <table class="table table-bordered"
                           id="table-detail">

                        <thead class="table-light">

                            <tr>

                                <th width="35%">
                                    Barang
                                </th>

                                <th width="15%">
                                    Qty
                                </th>

                                <th width="20%">
                                    Harga
                                </th>

                                <th width="20%">
                                    Subtotal
                                </th>

                                <th width="10%">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <td>

                                    <select name="barang_id[]"
                                            class="form-select barang-select"
                                            required>

                                        <option value="">
                                            Pilih Barang
                                        </option>

                                        @foreach($barangs as $barang)

                                            <option value="{{ $barang->id }}"
                                                    data-harga="{{ $barang->harga_beli }}">

                                                {{ $barang->nama_barang }}
                                                (Stok : {{ $barang->stok }})

                                            </option>

                                        @endforeach

                                    </select>

                                </td>

                                <td>

                                    <input type="number"
                                           name="qty[]"
                                           class="form-control qty"
                                           min="1"
                                           required>

                                </td>

                                <td>

                                    <input type="number"
                                           name="harga_beli[]"
                                           class="form-control harga"
                                           min="0"
                                           required>

                                </td>

                                <td>

                                    <input type="text"
                                           class="form-control subtotal"
                                           readonly>

                                </td>

                                <td class="text-center">

                                    <button type="button"
                                            class="btn btn-danger btn-sm remove-row">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <button type="button"
                        id="add-row"
                        class="btn btn-success my-3">

                    <i class="bi bi-plus-circle"></i>
                    Tambah Barang

                </button>

                <div class="mb-3">

                    <label class="form-label">
                        Keterangan
                    </label>

                    <textarea name="keterangan"
                              rows="3"
                              class="form-control">{{ old('keterangan') }}</textarea>

                </div>

                <button type="submit"
                        class="btn btn-primary">

                    <i class="bi bi-save"></i>
                    Simpan

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

function hitungSubtotal(row)
{
    let qty =
        parseFloat(
            row.find('.qty').val()
        ) || 0;

    let harga =
        parseFloat(
            row.find('.harga').val()
        ) || 0;

    let subtotal =
        qty * harga;

    row.find('.subtotal').val(
        subtotal.toLocaleString('id-ID')
    );
}

$(document).on(
    'keyup change',
    '.qty,.harga',
    function () {

        hitungSubtotal(
            $(this).closest('tr')
        );

    }
);

$(document).on(
    'change',
    '.barang-select',
    function () {

        let harga =
            $(this)
            .find(':selected')
            .data('harga');

        $(this)
            .closest('tr')
            .find('.harga')
            .val(harga);

        hitungSubtotal(
            $(this).closest('tr')
        );
    }
);

$('#add-row').click(function () {

    let row =
        $('#table-detail tbody tr:first')
        .clone();

    row.find('input').val('');
    row.find('select').val('');

    $('#table-detail tbody')
        .append(row);

});

$(document).on(
    'click',
    '.remove-row',
    function () {

        if (
            $('#table-detail tbody tr')
            .length > 1
        ) {

            $(this)
                .closest('tr')
                .remove();
        }

    }
);

</script>

@endpush