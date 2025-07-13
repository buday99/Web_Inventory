<!DOCTYPE html>
<html>
<head>
    <title>Laporan Barang Masuk & Keluar</title>
    <style>
        /* Styling dasar untuk PDF */
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 18pt;
        }
        .header p {
            margin: 0;
            font-size: 10pt;
        }
        .date-range {
            margin-bottom: 20px;
            font-size: 10pt;
        }
        .product-image {
            width: 50px; /* Ukuran gambar di PDF */
            height: 50px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Barang Masuk & Keluar</h1>
        <p>Sistem Inventory PT. Gudang Jaya Abadi</p>
    </div>

    <div class="date-range">
        <strong>Periode Laporan:</strong>
        @if ($startDate && $endDate)
            {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
        @else
            Semua Periode
        @endif
    </div>

    <h3>Laporan Barang Masuk</h3>
    <table>
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>SKU</th>
                <th>Kuantitas</th>
                <th>Tanggal Masuk</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stockIns as $stockIn)
                <tr>
                    <td>
                        @if ($stockIn->product && $stockIn->product->image)
                            <img src="{{ public_path('storage/' . $stockIn->product->image) }}" alt="{{ $stockIn->product->name }}" class="product-image">
                        @else
                            Tidak ada gambar
                        @endif
                    </td>
                    <td>{{ $stockIn->product->name }}</td>
                    <td>{{ $stockIn->product->sku }}</td>
                    <td>{{ $stockIn->quantity }}</td>
                    <td>{{ $stockIn->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $stockIn->notes ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data barang masuk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Laporan Barang Keluar</h3>
    <table>
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>SKU</th>
                <th>Kuantitas</th>
                <th>Tanggal Keluar</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stockOuts as $stockOut)
                <tr>
                    <td>
                        @if ($stockOut->product && $stockOut->product->image)
                            <img src="{{ public_path('storage/' . $stockOut->product->image) }}" alt="{{ $stockOut->product->name }}" class="product-image">
                        @else
                            Tidak ada gambar
                        @endif
                    </td>
                    <td>{{ $stockOut->product->name }}</td>
                    <td>{{ $stockOut->product->sku }}</td>
                    <td>{{ $stockOut->quantity }}</td>
                    <td>{{ $stockOut->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $stockOut->notes ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data barang keluar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>