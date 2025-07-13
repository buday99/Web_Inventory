<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Konstruktor untuk menerapkan middleware permission.
     *
     * Admin bisa melihat (view).
     * Super Admin bisa melihat, membuat, mengedit, dan menghapus.
     */
    public function __construct()
    {
        // Pengguna dengan permission 'view customers' dapat mengakses index dan show.
        // Ini berlaku untuk role 'admin' dan 'super-admin'.
        $this->middleware(['permission:view customers'])->only('index', 'show');

        // Pengguna dengan permission 'create customers' dapat mengakses create dan store.
        // Ini hanya berlaku untuk role 'super-admin'.
        $this->middleware(['permission:create customers'])->only('create', 'store');

        // Pengguna dengan permission 'edit customers' dapat mengakses edit dan update.
        // Ini hanya berlaku untuk role 'super-admin'.
        $this->middleware(['permission:edit customers'])->only('edit', 'update');

        // Pengguna dengan permission 'delete customers' dapat mengakses destroy.
        // Ini hanya berlaku untuk role 'super-admin'.
        $this->middleware(['permission:delete customers'])->only('destroy');
    }

    /**
     * Menampilkan daftar semua customer.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    /**
     * Menampilkan formulir untuk membuat customer baru.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Menyimpan customer baru ke database.
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

        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail customer tertentu.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Menampilkan formulir untuk mengedit customer yang sudah ada.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Memperbarui customer di database.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil diperbarui!');
    }

    /**
     * Menghapus customer dari database.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}