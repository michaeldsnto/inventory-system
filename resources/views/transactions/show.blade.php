@extends('layouts.app')

@section('title', 'Transaction Details')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Transaction Details</h2>
        <a href="{{ route('transactions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
            <i class="fas fa-arrow-left mr-1"></i>Back
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b bg-gray-50">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $transaction->transaction_number }}</h3>
                    <p class="text-sm text-gray-600">{{ $transaction->transaction_date->format('F d, Y H:i:s') }}</p>
                </div>
                <div>
                    <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $transaction->type == 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        <i class="fas fa-arrow-{{ $transaction->type == 'in' ? 'down' : 'up' }} mr-1"></i>
                        STOCK {{ strtoupper($transaction->type) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Item Information -->
                <div class="space-y-4">
                    <h4 class="text-md font-semibold text-gray-700 border-b pb-2">Item Information</h4>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Item Name</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $transaction->item->name }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">SKU</label>
                        <p class="text-gray-900">{{ $transaction->item->sku }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Category</label>
                        <p class="text-gray-900">{{ $transaction->item->category->name }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Supplier</label>
                        <p class="text-gray-900">{{ $transaction->item->supplier->name }}</p>
                    </div>
                </div>

                <!-- Transaction Details -->
                <div class="space-y-4">
                    <h4 class="text-md font-semibold text-gray-700 border-b pb-2">Transaction Details</h4>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Transaction Type</label>
                        <p class="text-lg font-semibold {{ $transaction->type == 'in' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type == 'in' ? 'Stock In (Receive)' : 'Stock Out (Issue)' }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Quantity</label>
                        <p class="text-2xl font-bold text-gray-900">{{ $transaction->quantity }} {{ $transaction->item->unit }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Previous Stock</label>
                            <p class="text-xl font-semibold text-gray-700">{{ $transaction->previous_stock }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">New Stock</label>
                            <p class="text-xl font-semibold text-indigo-600">{{ $transaction->new_stock }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Processed By</label>
                        <p class="text-gray-900">{{ $transaction->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $transaction->user->email }}</p>
                    </div>
                </div>

                @if($transaction->remarks)
                <div class="md:col-span-2">
                    <h4 class="text-md font-semibold text-gray-700 border-b pb-2 mb-3">Remarks</h4>
                    <p class="text-gray-900 bg-gray-50 p-4 rounded-md">{{ $transaction->remarks }}</p>
                </div>
                @endif

                <div class="md:col-span-2 pt-4 border-t">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <label class="text-gray-500">Transaction Created</label>
                            <p class="text-gray-900">{{ $transaction->created_at->format('M d, Y H:i:s') }}</p>
                        </div>
                        <div>
                            <label class="text-gray-500">Last Updated</label>
                            <p class="text-gray-900">{{ $transaction->updated_at->format('M d, Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 border-t bg-gray-50">
            <div class="flex justify-between items-center">
                <a href="{{ route('items.show', $transaction->item) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                    <i class="fas fa-box mr-1"></i>View Item Details
                </a>
                <button onclick="window.print()" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    <i class="fas fa-print mr-1"></i>Print
                </button>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    nav, .no-print {
        display: none !important;
    }
}
</style>
@endsection