<?php

namespace App\Http\Controllers;

use App\Models\DistributionDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class DistributionProductController extends Controller
{
    // List temporary products (all details with distribution_id = null)
    public function index(Request $request)
    {
        $items = DistributionDetail::with('product')
            ->whereNull('distribution_id')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($d) {
                return [
                    'id' => $d->id,
                    'product' => $d->product->name,
                    'price' => number_format($d->price, 2, ',', '.'),
                    'qty' => $d->qty,
                    'total' => number_format($d->total, 2, ',', '.'),
                ];
            });


        return response()->json(['data' => $items]);
    }


    public function store(Request $request)
    {
        $payload = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1'
        ]);


        $product = Product::findOrFail($payload['product_id']);
        $price = $product->price;
        $total = $price * $payload['qty'];


        $detail = DistributionDetail::create([
            'distribution_id' => null,
            'product_id' => $product->id,
            'qty' => $payload['qty'],
            'price' => $price,
            'total' => $total,
            'created_by' => 1, // TODO: auth()->id()
        ]);


        return response()->json(['ok' => true, 'detail_id' => $detail->id]);
    }


    public function destroy($id)
    {
        $d = DistributionDetail::findOrFail($id);
        if ($d->distribution_id) {
        }
    }
}
