<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Tambahkan ini

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view reports'])->only('index');
        $this->middleware(['permission:generate pdf reports'])->only('generatePdf'); // Izin khusus untuk PDF
    }
    
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $stockIns = StockIn::with('product')
                        ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
                        ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate))
                        ->latest()
                        ->get();

        $stockOuts = StockOut::with('product')
                         ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
                         ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate))
                         ->latest()
                         ->get();

        return view('reports.index', compact('stockIns', 'stockOuts', 'startDate', 'endDate'));
    }

    // Metode baru untuk generate PDF
    public function generatePdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $stockIns = StockIn::with('product')
                        ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
                        ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate))
                        ->latest()
                        ->get();

        $stockOuts = StockOut::with('product')
                         ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
                         ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate))
                         ->latest()
                         ->get();

        // Load view khusus PDF dengan data laporan
        $pdf = Pdf::loadView('reports.pdf_template', compact('stockIns', 'stockOuts', 'startDate', 'endDate'));

        // Opsional: Atur ukuran kertas dan orientasi
        // $pdf->setPaper('A4', 'landscape');

        // Unduh PDF
        return $pdf->download('laporan-barang-' . date('Ymd_His') . '.pdf');
    }
}