@extends('layouts.app')


@section('content')
    <h2>Detail Distribusi #{{ $distribution->id }}</h2>
    <p>Barista: {{ $distribution->barista->name }}</p>
    <p>Tanggal: {{ $distribution->created_at }}</p>
    <p>Total Qty: {{ $distribution->total_qty }}</p>
    <p>Estimasi: {{ $distribution->estimated_result }}</p>
    <h4>Produk</h4>
    <table border="1">
        <thead>
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
                    <td>{{ $d->price }}</td>
                    <td>{{ $d->qty }}</td>
                    <td>{{ $d->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
