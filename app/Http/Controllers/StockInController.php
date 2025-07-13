<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view stock-ins'])->only('index');
        $this->middleware(['permission:create stock-ins'])->only('create', 'store');
    }
    
    public function index()
    {
        $stockIns = StockIn::with('product')->latest()->get();
        return view('stock_ins.index', compact('stockIns'));
    }

    public function create()
    {
        $products = Product::all();
        return view('stock_ins.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            StockIn::create($request->all());

            $product = Product::find($request->product_id);
            $product->increment('stock', $request->quantity);
        });

        return redirect()->route('stock-ins.index')->with('success', 'Barang masuk berhasil dicatat!');
    }

    // Metode show, edit, update, destroy bisa ditambahkan jika diperlukan,
    // namun untuk stock in/out biasanya hanya create dan index yang utama.
    // Jika Anda ingin mengizinkan edit quantity stock in, Anda juga perlu mengupdate stok produk.
}