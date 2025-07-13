<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Pastikan ini di-import

class ProductController extends Controller
{
    /**
     * Konstruktor untuk menerapkan middleware permission.
     *
     * Admin bisa melihat (view).
     * Super Admin bisa melihat, membuat, mengedit, dan menghapus.
     */
    public function __construct()
    {
        // Pengguna dengan permission 'view products' dapat mengakses index dan show.
        // Ini berlaku untuk role 'admin' dan 'super-admin'.
        $this->middleware(['permission:view products'])->only('index', 'show');

        // Pengguna dengan permission 'create products' dapat mengakses create dan store.
        // Ini hanya berlaku untuk role 'super-admin'.
        $this->middleware(['permission:create products'])->only('create', 'store');

        // Pengguna dengan permission 'edit products' dapat mengakses edit dan update.
        // Ini hanya berlaku untuk role 'super-admin'.
        $this->middleware(['permission:edit products'])->only('edit', 'update');

        // Pengguna dengan permission 'delete products' dapat mengakses destroy.
        // Ini hanya berlaku untuk role 'super-admin'.
        $this->middleware(['permission:delete products'])->only('destroy');
    }

    /**
     * Menampilkan daftar semua produk.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan formulir untuk membuat produk baru.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar
        ]);

        $imagePath = null;
        // Jika ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            // Simpan gambar di direktori 'products' dalam storage publik
            // dan dapatkan path-nya (misal: products/nama_file_unik.jpg)
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Buat produk baru di database
        Product::create([
            'name' => $request->name,
            'sku' => $request->sku,
            'description' => $request->description,
            'image' => $imagePath, // Simpan path gambar
            // 'stock' tidak perlu diisi di sini karena defaultnya 0 di migration
        ]);

        // Redirect kembali ke halaman daftar produk dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail produk tertentu.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan formulir untuk mengedit produk yang sudah ada.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Memperbarui produk di database.
     */
    public function update(Request $request, Product $product)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $product->id . '|max:255', // SKU unik kecuali untuk produk itu sendiri
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar
        ]);

        // Ambil hanya data yang diizinkan untuk update
        $data = $request->only(['name', 'sku', 'description']);

        // Jika ada file gambar baru yang diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada sebelum menyimpan yang baru
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->boolean('remove_image')) {
            // Jika checkbox 'remove_image' dicentang, hapus gambar lama dan set kolom image menjadi null
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
                $data['image'] = null;
            }
        }

        // Perbarui data produk di database
        $product->update($data);

        // Redirect kembali ke halaman daftar produk dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Barang berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Product $product)
    {
        // Hapus gambar terkait dari storage jika ada
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Hapus produk dari database
        $product->delete();

        // Redirect kembali ke halaman daftar produk dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Barang berhasil dihapus!');
    }
}