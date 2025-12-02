<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['item', 'user']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->paginate(20);

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $items = Item::where('is_active', true)->get();
        return view('transactions.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'remarks' => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            $item = Item::findOrFail($validated['item_id']);
            
            // Check if stock out is valid
            if ($validated['type'] === 'out' && $item->quantity < $validated['quantity']) {
                return back()->withErrors(['quantity' => 'Insufficient stock available.'])->withInput();
            }

            $previousStock = $item->quantity;
            
            // Update item quantity
            if ($validated['type'] === 'in') {
                $item->quantity += $validated['quantity'];
            } else {
                $item->quantity -= $validated['quantity'];
            }
            $item->save();

            // Create transaction
            Transaction::create([
                'transaction_number' => Transaction::generateTransactionNumber(),
                'item_id' => $validated['item_id'],
                'user_id' => auth()->id(),
                'type' => $validated['type'],
                'quantity' => $validated['quantity'],
                'previous_stock' => $previousStock,
                'new_stock' => $item->quantity,
                'remarks' => $validated['remarks'],
                'transaction_date' => now(),
            ]);

            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', 'Transaction recorded successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Transaction failed: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['item', 'user']);
        return view('transactions.show', compact('transaction'));
    }
}