<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\DistributionDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->data($request);
        }


        return view('distributions.index');
    }


    // Data for DataTables server-side
    public function data(Request $request)
    {
        $query = Distribution::with('barista')->orderBy('created_at', 'desc');


        // Server-side processing for DataTables (basic)
        $total = $query->count();
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $search = $request->input('search.value');


        if ($search) {
            $query->whereHas('barista', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }


        $data = $query->skip($start)->take($length)->get();


        $formatted = $data->map(function ($d) {
            return [
                'id' => $d->id,
                'created_at' => $d->created_at->format('Y-m-d H:i'),
                'barista' => $d->barista?->name,
                'total_qty' => $d->total_qty,
                'estimated_result' => number_format($d->estimated_result, 2, ',', '.'),
                'notes' => $d->notes,
                'actions' => ''
            ];
        });


        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $formatted,
        ]);
    }


    public function create()
    {
        $baristas = User::where('role', 'barista')->get();
        $products = Product::where('active', true)->get();
        return view('distributions.create', compact('baristas', 'products'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'barista_id' => 'required|exists:users,id',
            'notes' => 'nullable|string'
        ]);

        $detailIds = $request->input('detail_ids'); // expect array of distribution_detail ids that were temporary

        if (empty($detailIds) || !is_array($detailIds)) {
            return redirect()->back()->withErrors('Tidak ada produk yang ditambahkan.');
        }

        DB::beginTransaction();
        try {
            // calculate totals from distribution_details
            $details = DistributionDetail::whereIn('id', $detailIds)->get();
            $totalQty = $details->sum('qty');
            $estimated = $details->sum('total');

            $distribution = Distribution::create([
                'barista_id' => $request->barista_id,
                'total_qty' => $totalQty,
                'estimated_result' => $estimated,
                'notes' => $request->notes,
                'created_by' => 1, // TODO: replace with auth()->id()
            ]);

            // attach details to distribution
            foreach ($details as $d) {
                $d->distribution_id = $distribution->id;
                $d->save();
            }

            DB::commit();
            return redirect()->route('distributions.index')->with('success', 'Distribusi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function show($id)
    {
        $distribution = Distribution::with('details.product', 'barista')->findOrFail($id);
        return view('distributions.show', compact('distribution'));
    }

    public function destroy($id)
    {
        $dist = Distribution::findOrFail($id);
        $dist->delete();
        return response()->json(['ok' => true]);
    }
}
