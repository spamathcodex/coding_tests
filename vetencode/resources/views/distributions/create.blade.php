@extends('layouts.app')


@section('content')
    <h3 class="fw-semibold text-secondary mb-3">Tambah Distribusi Baru</h3>


    <form id="main-form" method="POST" action="{{ route('distributions.store') }}" class="needs-validation" novalidate>
        @csrf

        <div class="mb-3">
            <label for="barista_id" class="form-label">Pilih Barista</label>
            <select name="barista_id" id="barista_id" class="form-select @error('barista_id') is-invalid @enderror"
                required>
                <option value="">-- Pilih Barista --</option>
                @foreach($baristas as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                @endforeach
            </select>
            @error('barista_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Tambah Produk</div>
            <div class="card-body">
                <div class="row g-2 align-items-end">
                    <div class="col-md-6">
                        <label for="product-select" class="form-label">Produk</label>
                        <select id="product-select" class="form-select">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" data-price="{{ $p->price }}">{{ $p->name }} -
                                    Rp{{ number_format($p->price, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="qty" class="form-label">Qty</label>
                        <input type="number" id="qty" class="form-control" min="1" value="1">
                    </div>
                    <div class="col-md-3 text-end">
                        <button id="add-product" type="button" class="btn btn-success w-100">Tambah</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-light fw-semibold">Produk Sementara</div>
            <div class="card-body p-0">
                <table id="temp-table" class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-between fw-semibold">
                <span>Total Qty: <span id="total-qty">0</span></span>
                <span>Estimasi Penjualan: Rp<span id="est-result">0</span></span>
            </div>
        </div>

        <input type="hidden" name="detail_ids" id="detail_ids">

        <div class="mb-3">
            <label for="notes" class="form-label">Catatan</label>
            <textarea name="notes" id="notes" rows="3" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Simpan Distribusi</button>
    </form>
@endsection

@push('scripts')
    <script>
        $(function () {
            function refreshTemp() {
                $.getJSON('{{ route('distribution-products.index') }}', function (res) {
                    let tbody = $('#temp-table tbody').empty();
                    let totalQty = 0, est = 0, ids = [];
                    res.data.forEach(function (item) {
                        tbody.append(`<tr>
                                        <td>${item.product}</td>
                                        <td>${item.price}</td>
                                        <td>${item.qty}</td>
                                        <td>${item.total}</td>
                                        <td><button class='btn btn-sm btn-outline-danger remove' data-id='${item.id}'>Hapus</button></td>
                                    </tr>`);
                        totalQty += parseInt(item.qty);
                        est += parseFloat(item.total.replace('.', '').replace(',', '.'));
                        ids.push(item.id);
                    });
                    $('#total-qty').text(totalQty);
                    $('#est-result').text(est.toLocaleString('id-ID'));
                    $('#detail_ids').val(JSON.stringify(ids));
                });
            }

            $('#add-product').on('click', function () {
                let pid = $('#product-select').val();
                let qty = parseInt($('#qty').val()) || 1;
                if (!pid) return alert('Pilih produk terlebih dahulu');
                $.post('{{ route('distribution-products.store') }}', { _token: '{{ csrf_token() }}', product_id: pid, qty: qty }, function () { refreshTemp(); });
            });

            $(document).on('click', '.remove', function (e) {
                e.preventDefault();
                $.ajax({ url: '/distribution-products/' + $(this).data('id'), method: 'DELETE', data: { _token: '{{ csrf_token() }}' }, success: refreshTemp });
            });

            $('#main-form').on('submit', function (e) {
                let ids = $('#detail_ids').val();
                if (!ids || ids === '[]') { e.preventDefault(); alert('Tambahkan minimal satu produk'); return; }
                JSON.parse(ids).forEach(function (id) { $(e.target).append(`<input type='hidden' name='detail_ids[]' value='${id}'>`); });
            });

            refreshTemp();
        });
    </script>
@endpush