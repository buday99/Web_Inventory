<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Barang Masuk & Keluar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('reports.index') }}" method="GET" class="mb-6 flex items-end space-x-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                            <input type="date" name="start_date" id="start_date" class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $startDate }}">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                            <input type="date" name="end_date" id="end_date" class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $endDate }}">
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filter</button>
                        <a href="{{ route('reports.index') }}" class="ml-4 text-gray-600 hover:text-gray-900 py-2 px-4">Reset</a>
                    </form>

                    {{-- Tombol Cetak PDF hanya tampil jika user memiliki permission 'generate pdf reports' --}}
                    @can('generate pdf reports')
                        <div class="mb-6">
                            {{-- Kirim parameter tanggal agar PDF juga terfilter --}}
                            <a href="{{ route('reports.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2v2h-2m0-12H5V7m0 10V3a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2zM12 11V5"></path></svg>
                                Cetak Laporan PDF
                            </a>
                        </div>
                    @endcan


                    <h3 class="text-lg font-semibold mb-4">Laporan Barang Masuk</h3>
                    <table class="min-w-full divide-y divide-gray-200 mb-8">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kuantitas</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Masuk</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($stockIns as $stockIn)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($stockIn->product && $stockIn->product->image)
                                            <img src="{{ asset('storage/' . $stockIn->product->image) }}" alt="{{ $stockIn->product->name }}" class="w-16 h-16 object-cover rounded-sm">
                                        @else
                                            <span class="text-gray-400">Tidak ada gambar</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $stockIn->product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $stockIn->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $stockIn->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $stockIn->notes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data barang masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <h3 class="text-lg font-semibold mb-4">Laporan Barang Keluar</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kuantitas</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Keluar</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($stockOuts as $stockOut)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($stockOut->product && $stockOut->product->image)
                                            <img src="{{ asset('storage/' . $stockOut->product->image) }}" alt="{{ $stockOut->product->name }}" class="w-16 h-16 object-cover rounded-sm">
                                        @else
                                            <span class="text-gray-400">Tidak ada gambar</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $stockOut->product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $stockOut->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $stockOut->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $stockOut->notes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data barang keluar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>