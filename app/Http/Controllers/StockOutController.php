<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockOutController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:view stock-outs'])->only('index');
        $this->middleware(['permission:create stock-outs'])->only('create', 'store');
    }

    public function index()
    {
        $stockOuts = StockOut::with('product')->latest()->get();
        return view('stock_outs.index', compact('stockOuts'));
    }

    public function create()
    {
        $products = Product::all();
        return view('stock_outs.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $product = Product::find($request->product_id);

        if ($request->quantity > $product->stock) {
            return redirect()->back()->withErrors(['quantity' => 'Kuantitas barang keluar melebihi stok yang tersedia.'])->withInput();
        }

        DB::transaction(function () use ($request, $product) {
            StockOut::create($request->all());
            $product->decrement('stock', $request->quantity);
        });

        return redirect()->route('stock-outs.index')->with('success', 'Barang keluar berhasil dicatat!');
    }

    // Metode show, edit, update, destroy bisa ditambahkan jika diperlukan
}