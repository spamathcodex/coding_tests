@extends('layouts.app')


@section('content')
<h2>Tambah Distribusi</h2>


<form id="main-form" method="post" action="{{ route('distributions.store') }}">
    @csrf
    <div>
        <label>Barista</label>
        <select name="barista_id" id="barista_id">
            @foreach($baristas as $b)
                <option value="{{ $b->id }}">{{ $b->name }}</option>
            @endforeach
        </select>
    </div>


    <div style="margin-top:10px;">
        <h4>Tambah Produk</h4>
        <select id="product-select">
            <option value="">-- Pilih Produk --</option>
            @foreach($products as $p)
                <option value="{{ $p->id }}" data-price="{{ $p->price }}">{{ $p->name }} - {{ $p->price }}</option>
            @endforeach
        </select>
        <input type="number" id="qty" min="1" value="1">
        <button id="add-product" type="button">Tambah</button>
    </div>


    <div style="margin-top:10px;">
        <h4>Produk Sementara</h4>
        <table id="temp-table" border="1" style="width:100%;">
            <thead>
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


        <div style="margin-top:10px">
            <strong>Total Qty: </strong><span id="total-qty">0</span><br>
            <strong>Estimasi Penjualan: </strong><span id="est-result">0</span>
        </div>
    </div>


    <input type="hidden" name="detail_ids" id="detail_ids">


    <div style="margin-top:10px;">
        <label>Notes</label>
        <textarea name="notes"></textarea>
    </div>


    <div style="margin-top:10px;">
        <button type="submit">Simpan Distribusi</button>
    </div>
</form>
@endsection

@push('scripts')
    <script>
        $(function () {
            function refreshTemp() {
                $.getJSON('{{ route('distribution-products.index') }}', function (res) {
                    var tbody = $('#temp-table tbody').empty();
                    var totalQty = 0; var est = 0; var ids = [];
                    res.data.forEach(function (item) {
                        tbody.append('<tr data-id="' + item.id + '"><td>' + item.product + '</td><td>' + item.price + '</td><td>' + item.qty + '</td><td>' + item.total + '</td><td><a href="#" class="remove" data-id="' + item.id + '">Hapus</a></td></tr>');
                        // parse numbers from formatted strings not ideal but acceptable here
                        totalQty += parseInt(item.qty);
                        est += parseFloat(item.total.replace('.', '').replace(',', '.'));
                        ids.push(item.id);
                    });
                    $('#total-qty').text(totalQty);
                    $('#est-result').text(est);
                    $('#detail_ids').val(JSON.stringify(ids));
                });
            }

            $('#add-product').on('click', function () {
                var pid = $('#product-select').val();
                var qty = parseInt($('#qty').val()) || 1;
                if (!pid) return alert('Pilih produk');
                $.post('{{ route('distribution-products.store') }}', { _token: '{{ csrf_token() }}', product_id: pid, qty: qty }, function (res) {
                    refreshTemp();
                }).fail(function (err) { alert('Gagal menambah'); });
            });

            $(document).on('click', '.remove', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({ url: '/distribution-products/' + id, method: 'DELETE', data: { _token: '{{ csrf_token() }}' }, success: function () { refreshTemp(); } });
            });

            $('#main-form').on('submit', function (e) {
                // pass detail_ids as array (server expects array or JSON string)
                var ids = $('#detail_ids').val();
                if (!ids || ids === '[]' || ids === '') { e.preventDefault(); alert('Tidak ada produk'); return; }
                // transform the hidden field to a real array input
                var arr = JSON.parse(ids);
                arr.forEach(function (id) {
                    $(e.target).append('<input type="hidden" name="detail_ids[]" value="' + id + '" />');
                });
            });

            refreshTemp();
        });
    </script>
@endpush
