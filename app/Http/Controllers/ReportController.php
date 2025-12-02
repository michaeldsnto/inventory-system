<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ItemsExport;
use App\Exports\TransactionsExport;

class ReportController extends Controller
{
    public function inventory()
    {
        return view('reports.inventory');
    }

    public function inventoryPdf()
    {
        $items = Item::with(['category', 'supplier'])->get();
        $pdf = Pdf::loadView('reports.pdf.inventory', compact('items'));
        return $pdf->download('inventory-report-' . now()->format('Y-m-d') . '.pdf');
    }

    public function inventoryExcel()
    {
        return Excel::download(new ItemsExport, 'inventory-report-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function transactions(Request $request)
    {
        $query = Transaction::with(['item', 'user']);

        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->get();

        return view('reports.transactions', compact('transactions'));
    }

    public function transactionsPdf(Request $request)
    {
        $query = Transaction::with(['item', 'user']);

        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->get();
        $pdf = Pdf::loadView('reports.pdf.transactions', compact('transactions'));
        return $pdf->download('transactions-report-' . now()->format('Y-m-d') . '.pdf');
    }

    public function transactionsExcel(Request $request)
    {
        return Excel::download(new TransactionsExport($request->all()), 'transactions-report-' . now()->format('Y-m-d') . '.xlsx');
    }
}