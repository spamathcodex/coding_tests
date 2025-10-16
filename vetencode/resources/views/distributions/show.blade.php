{{-- @extends('layouts.app')


@section('content')
<h3 class="fw-semibold text-secondary mb-3">Detail Distribusi #{{ $distribution->id }}</h3>


<div class="card mb-3">
    <div class="card-body">
        <p><strong>Barista:</strong> {{ $distribution->barista->name }}</p>
        <p><strong>Tanggal:</strong> {{ $distribution->created_at }}</p>
        <p><strong>Total Qty:</strong> {{ $distribution->total_qty }}</p>
        <p><strong>Estimasi Penjualan:</strong> Rp{{ number_format($distribution->estimated_result, 0, ',', '.') }}</p>
    </div>
</div>


<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($distribution->details as $d)
        <tr>
            <td>{{ $d->product->name }}</td>
            <td>Rp{{ number_format($d->price, 0, ',', '.') }}</td>
            <td>{{ $d->qty }}</td>
            <td>Rp{{ number_format($d->total, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection --}}

<div>
    <div class="mb-3">
        <h6 class="fw-bold mb-1">Barista:</h6>
        <p class="mb-2">{{ $distribution->barista->name }}</p>
    </div>
    <div class="mb-3">
        <h6 class="fw-bold mb-1">Tanggal:</h6>
        <p class="mb-2">{{ $distribution->created_at }}</p>
    </div>
    <div class="mb-3">
        <h6 class="fw-bold mb-1">Total Qty:</h6>
        <p class="mb-2">{{ $distribution->total_qty }}</p>
    </div>
    <div class="mb-3">
        <h6 class="fw-bold mb-1">Estimasi Penjualan:</h6>
        <p class="mb-2">Rp{{ number_format($distribution->estimated_result, 0, ',', '.') }}</p>
    </div>


    <hr>
    <h6 class="fw-bold mb-2">Daftar Produk</h6>
    <table class="table table-bordered table-sm">
        <thead class="table-light">
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($distribution->details as $d)
                <tr>
                    <td>{{ $d->product->name }}</td>
                    <td>Rp{{ number_format($d->price, 0, ',', '.') }}</td>
                    <td>{{ $d->qty }}</td>
                    <td>Rp{{ number_format($d->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>