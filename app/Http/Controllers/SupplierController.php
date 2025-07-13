<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Konstruktor untuk menerapkan middleware permission.
     *
     * Admin bisa melihat (view).
     * Super Admin bisa melihat, membuat, mengedit, dan menghapus.
     */
    public function __construct()
    {
        // Pengguna dengan permission 'view suppliers' dapat mengakses index dan show.
        // Ini berlaku untuk role 'admin' dan 'super-admin'.
        $this->middleware(['permission:view suppliers'])->only('index', 'show');

        // Pengguna dengan permission 'create suppliers' dapat mengakses create dan store.
        // Ini hanya berlaku untuk role 'super-admin'.
        $this->middleware(['permission:create suppliers'])->only('create', 'store');

        // Pengguna dengan permission 'edit suppliers' dapat mengakses edit dan update.
        // Ini hanya berlaku untuk role 'super-admin'.
        $this->middleware(['permission:edit suppliers'])->only('edit', 'update');

        // Pengguna dengan permission 'delete suppliers' dapat mengakses destroy.
        // Ini hanya berlaku untuk role 'super-admin'.
        $this->middleware(['permission:delete suppliers'])->only('destroy');
    }

    /**
     * Menampilkan daftar semua supplier.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Menampilkan formulir untuk membuat supplier baru.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Menyimpan supplier baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Supplier::create($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail supplier tertentu.
     */
    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Menampilkan formulir untuk mengedit supplier yang sudah ada.
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Memperbarui supplier di database.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $supplier->update($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui!');
    }

    /**
     * Menghapus supplier dari database.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus!');
    }
}