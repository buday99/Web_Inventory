<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-center">Selamat datang di Sistem Inventory!</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        @php
                            // Ambil data statistik langsung di view (atau bisa juga dari controller)
                            $totalProducts = \App\Models\Product::count();
                            $totalStock = \App\Models\Product::sum('stock');
                            $totalSuppliers = \App\Models\Supplier::count();
                            $totalCustomers = \App\Models\Customer::count();
                        @endphp

                        <div class="bg-blue-50 p-6 rounded-lg shadow-md flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-semibold text-blue-800">Total Barang</h4>
                                <p class="text-3xl font-bold text-blue-600">{{ $totalProducts }}</p>
                            </div>
                            <svg class="w-12 h-12 text-blue-500 opacity-70" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM11 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z"></path></svg>
                        </div>

                        <div class="bg-green-50 p-6 rounded-lg shadow-md flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-semibold text-green-800">Total Stok Barang</h4>
                                <p class="text-3xl font-bold text-green-600">{{ $totalStock }}</p>
                            </div>
                            <svg class="w-12 h-12 text-green-500 opacity-70" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 3a1 1 0 00-1 1v1a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1H7zM7 8a1 1 0 00-1 1v1a1 1 0 001 1h2a1 1 0 001-1V9a1 1 0 00-1-1H7zM7 13a1 1 0 00-1 1v1a1 1 0 001 1h2a1 1 0 001-1v-1a1 1 0 00-1-1H7zM12 3a1 1 0 00-1 1v1a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1h-2zM12 8a1 1 0 00-1 1v1a1 1 0 001 1h2a1 1 0 001-1V9a1 1 0 00-1-1h-2zM12 13a1 1 0 00-1 1v1a1 1 0 001 1h2a1 1 0 001-1v-1a1 1 0 00-1-1h-2z"></path></svg>
                        </div>

                        <div class="bg-yellow-50 p-6 rounded-lg shadow-md flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-semibold text-yellow-800">Total Supplier</h4>
                                <p class="text-3xl font-bold text-yellow-600">{{ $totalSuppliers }}</p>
                            </div>
                            <svg class="w-12 h-12 text-yellow-500 opacity-70" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        </div>

                        <div class="bg-red-50 p-6 rounded-lg shadow-md flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-semibold text-red-800">Total Pelanggan</h4>
                                <p class="text-3xl font-bold text-red-600">{{ $totalCustomers }}</p>
                            </div>
                            <svg class="w-12 h-12 text-red-500 opacity-70" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17.555 17.08A1 1 0 0017 17h-4a1 1 0 00-.977.794L11.5 20h2.464l.953-2.859A.999.999 0 0014.5 16h-.911a.999.999 0 00-.988.824L12 19h1.996l.896-2.688A1 1 0 0014.5 16h-.911zM10 12a1 1 0 100-2 1 1 0 000 2z"></path></svg>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-4">Navigasi Cepat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <a href="{{ route('products.index') }}" class="block p-6 bg-blue-100 rounded-lg shadow hover:shadow-md transition duration-300 ease-in-out">
                            <h4 class="text-xl font-semibold text-blue-800 mb-2">Kelola Barang</h4>
                            <p class="text-blue-700">Tambah, edit, dan lihat daftar semua barang di gudang.</p>
                        </a>

                        <a href="{{ route('stock-ins.index') }}" class="block p-6 bg-green-100 rounded-lg shadow hover:shadow-md transition duration-300 ease-in-out">
                            <h4 class="text-xl font-semibold text-green-800 mb-2">Barang Masuk</h4>
                            <p class="text-green-700">Catat setiap barang baru yang masuk ke gudang.</p>
                        </a>

                        <a href="{{ route('stock-outs.index') }}" class="block p-6 bg-red-100 rounded-lg shadow hover:shadow-md transition duration-300 ease-in-out">
                            <h4 class="text-xl font-semibold text-red-800 mb-2">Barang Keluar</h4>
                            <p class="text-red-700">Data barang yang telah dikeluarkan dari gudang.</p>
                        </a>

                        <a href="{{ route('reports.index') }}" class="block p-6 bg-yellow-100 rounded-lg shadow hover:shadow-md transition duration-300 ease-in-out">
                            <h4 class="text-xl font-semibold text-yellow-800 mb-2">Laporan Barang</h4>
                            <p class="text-yellow-700">Lihat ringkasan dan riwayat transaksi barang.</p>
                        </a>

                        <a href="{{ route('company_profile.index') }}" class="block p-6 bg-purple-100 rounded-lg shadow hover:shadow-md transition duration-300 ease-in-out">
                            <h4 class="text-xl font-semibold text-purple-800 mb-2">Profil Perusahaan</h4>
                            <p class="text-purple-700">Informasi dasar tentang gudang atau perusahaan Anda.</p>
                        </a>

                        <a href="{{ route('suppliers.index') }}" class="block p-6 bg-orange-100 rounded-lg shadow hover:shadow-md transition duration-300 ease-in-out">
                            <h4 class="text-xl font-semibold text-orange-800 mb-2">Manajemen Supplier</h4>
                            <p class="text-orange-700">Daftar dan kelola pemasok barang.</p>
                        </a>

                        <a href="{{ route('customers.index') }}" class="block p-6 bg-pink-100 rounded-lg shadow hover:shadow-md transition duration-300 ease-in-out">
                            <h4 class="text-xl font-semibold text-pink-800 mb-2">Manajemen Pelanggan</h4>
                            <p class="text-pink-700">Daftar dan kelola pelanggan.</p>
                        </a>

                        {{-- Card untuk Manajemen User (Hanya Super Admin) --}}
                        @can('manage users')
                            <a href="{{ route('users.index') }}" class="block p-6 bg-gray-100 rounded-lg shadow hover:shadow-md transition duration-300 ease-in-out">
                                <h4 class="text-xl font-semibold text-gray-800 mb-2">Manajemen User</h4>
                                <p class="text-gray-700">Atur pengguna dan peran mereka dalam sistem.</p>
                            </a>
                        @endcan

                    </div>

                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-xl font-semibold mb-4">Kelebihan Aplikasi Inventory Kami:</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-2">
                            <li>Manajemen Stok Real-time: Pantau jumlah stok barang secara akurat setiap saat.</li>
                            <li>Pencatatan Transaksi Lengkap: Dokumentasi setiap barang masuk dan keluar dengan detail.</li>
                            <li>Pelaporan Akurat: Hasilkan laporan yang komprehensif untuk analisis dan pengambilan keputusan.</li>
                            <li>Antarmuka Pengguna Intuitif: Desain yang bersih dan mudah digunakan untuk pengalaman terbaik.</li>
                            <li>Didukung Teknologi Modern: Dibangun dengan Laravel 10 dan MySQL untuk kinerja dan keamanan.</li>
                            <li>Manajemen Master Data: Kelola daftar barang, supplier, dan pelanggan dengan mudah.</li>
                            <li>Sistem Hak Akses Berbasis Peran: Kontrol ketat atas fitur yang dapat diakses setiap pengguna.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>