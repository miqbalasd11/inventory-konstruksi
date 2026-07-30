@extends('layouts.app')

@section('title', 'Buat Purchase Order')

@section('content')

<div class="container-fluid">

    <form action="{{ route('purchase-orders.store') }}"
        method="POST">

        @csrf

        <div class="card shadow-sm mb-3">

            <div class="card-header">
                Header Purchase Order
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Material Request
                        </label>

                        <select name="material_request_id"
                            id="material_request_id"
                            class="form-control"
                            required>

                            <option value="">
                                Pilih Material Request
                            </option>

                            @foreach($materialRequests as $mr)

                            <option value="{{ $mr->id }}">
                                {{ $mr->nomor_mr }}
                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Supplier
                        </label>

                        <input
                            type="text"
                            name="supplier_nama"
                            class="form-control"
                            list="listSupplier"
                            placeholder="Pilih atau ketik supplier baru"
                            required>

                        <datalist id="listSupplier">

                            @foreach($suppliers as $supplier)

                            <option value="{{ $supplier->nama_supplier }}">
                            </option>

                            @endforeach

                        </datalist>

                        <small class="text-muted">
                            Jika supplier belum ada, akan otomatis dibuat.
                        </small>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Tanggal PO
                        </label>

                        <input type="date"
                            name="tanggal_po"
                            class="form-control"
                            value="{{ date('Y-m-d') }}"
                            required>

                    </div>

                </div>

            </div>

        </div>

        <div class="card shadow-sm">

            <div class="card-header">
                Detail Barang Material Request
            </div>

            <div class="card-body">

                <table class="table table-bordered mb-4">

                    <thead>

                        <tr>
                            <th>Barang</th>
                            <th width="120">Qty</th>
                            <th width="180">Harga</th>
                            <th width="180">Subtotal</th>
                        </tr>

                    </thead>

                    <tbody id="detailMR">

                        <tr>

                            <td colspan="4"
                                class="text-center">

                                Pilih Material Request

                            </td>

                        </tr>

                    </tbody>

                    <tfoot>

                        <tr>

                            <th colspan="3"
                                class="text-end">

                                Grand Total

                            </th>

                            <th>

                                <input type="text"
                                    id="grandTotal"
                                    class="form-control"
                                    readonly
                                    value="0">

                            </th>

                        </tr>

                    </tfoot>

                </table>

                <button type="submit"
                    class="btn btn-primary">

                    Simpan Purchase Order

                </button>

                <a href="{{ route('purchase-orders.index') }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </div>

        </div>

    </form>

</div>

<input type="hidden"
    id="mr-data"
    value='@json($materialRequests)'>

@endsection

@push('scripts')

<script>
    const materialRequests =
        JSON.parse(
            document.getElementById('mr-data').value
        );

    document
        .getElementById('material_request_id')
        .addEventListener(
            'change',
            function() {

                let id = this.value;

                let mr =
                    materialRequests.find(
                        item => item.id == id
                    );

                let html = '';

                if (
                    mr &&
                    mr.details.length > 0
                ) {

                    mr.details.forEach(function(detail) {

                        html += `
            <tr>

                <td>

                    ${detail.barang?.nama_barang ?? '-'}

                </td>

                <td>

                    ${detail.qty}

                </td>

                <td>

                    <input
                        type="number"
                        name="harga[${detail.barang_id}]"
                        class="form-control harga"
                        data-qty="${detail.qty}"
                        min="0"
                        value="0"
                        required>

                </td>

                <td>

                    <input
                        type="text"
                        class="form-control subtotal"
                        readonly
                        value="0">

                </td>

            </tr>
            `;

                    });

                } else {

                    html = `
        <tr>

            <td colspan="4"
                class="text-center">

                Tidak ada detail barang

            </td>

        </tr>
        `;
                }

                document
                    .getElementById('detailMR')
                    .innerHTML = html;

                bindHarga();

            });

    function bindHarga() {

        document
            .querySelectorAll('.harga')
            .forEach(function(input) {

                input.addEventListener(
                    'input',
                    hitungTotal
                );

            });

    }

    function hitungTotal() {

        let grandTotal = 0;

        document
            .querySelectorAll('.harga')
            .forEach(function(input) {

                let qty =
                    parseFloat(
                        input.dataset.qty
                    ) || 0;

                let harga =
                    parseFloat(
                        input.value
                    ) || 0;

                let subtotal =
                    qty * harga;

                input
                    .closest('tr')
                    .querySelector('.subtotal')
                    .value = subtotal;

                grandTotal += subtotal;

            });

        document
            .getElementById(
                'grandTotal'
            ).value = grandTotal;
    }
</script>

@endpush