@extends('layouts.app')

@section('title', 'Item Details')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Item Details</h2>
        <div class="space-x-2">
            @if(auth()->user()->isAdmin())
            <a href="{{ route('items.edit', $item) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">
                <i class="fas fa-edit mr-1"></i>Edit
            </a>
            @endif
            <a href="{{ route('items.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-1"></i>Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Item Information -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($item->image)
                    <div class="md:col-span-2">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" 
                            class="w-full h-64 object-cover rounded-lg">
                    </div>
                    @endif

                    <div>
                        <label class="text-sm font-medium text-gray-500">SKU</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $item->sku }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Name</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $item->name }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Category</label>
                        <p class="text-lg text-gray-900">{{ $item->category->name }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Supplier</label>
                        <p class="text-lg text-gray-900">{{ $item->supplier->name }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Current Stock</label>
                        <p class="text-2xl font-bold {{ $item->isLowStock() ? 'text-red-600' : 'text-green-600' }}">
                            {{ $item->quantity }} {{ $item->unit }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Minimum Stock Level</label>
                        <p class="text-lg text-gray-900">{{ $item->min_stock_level }} {{ $item->unit }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Unit Price</label>
                        <p class="text-lg font-semibold text-gray-900">${{ number_format($item->unit_price, 2) }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Total Value</label>
                        <p class="text-lg font-semibold text-gray-900">
                            ${{ number_format($item->quantity * $item->unit_price, 2) }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Status</label>
                        <p>
                            @if($item->isLowStock())
                            <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-800 font-medium">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Low Stock
                            </span>
                            @else
                            <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800 font-medium">
                                <i class="fas fa-check-circle mr-1"></i>In Stock
                            </span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Item Status</label>
                        <p>
                            <span class="px-3 py-1 text-sm rounded-full {{ $item->is_active ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>

                    @if($item->description)
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-500">Description</label>
                        <p class="text-gray-900 mt-1">{{ $item->description }}</p>
                    </div>
                    @endif

                    <div class="md:col-span-2 grid grid-cols-2 gap-4 pt-4 border-t">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Created At</label>
                            <p class="text-sm text-gray-900">{{ $item->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Last Updated</label>
                            <p class="text-sm text-gray-900">{{ $item->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('transactions.create', ['item' => $item->id]) }}" 
                        class="block w-full bg-green-600 text-white px-4 py-3 rounded-md hover:bg-green-700 text-center">
                        <i class="fas fa-plus-circle mr-2"></i>Stock In
                    </a>
                    <a href="{{ route('transactions.create', ['item' => $item->id]) }}" 
                        class="block w-full bg-red-600 text-white px-4 py-3 rounded-md hover:bg-red-700 text-center">
                        <i class="fas fa-minus-circle mr-2"></i>Stock Out
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Stock Summary</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b">
                        <span class="text-gray-600">Total Transactions</span>
                        <span class="font-semibold text-gray-900">{{ $item->transactions->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b">
                        <span class="text-gray-600">Total Stock In</span>
                        <span class="font-semibold text-green-600">
                            {{ $item->transactions->where('type', 'in')->sum('quantity') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Stock Out</span>
                        <span class="font-semibold text-red-600">
                            {{ $item->transactions->where('type', 'out')->sum('quantity') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Transaction History</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Transaction #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Previous</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">New Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($item->transactions()->latest('transaction_date')->take(20)->get() as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $transaction->transaction_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $transaction->transaction_date->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 py-1 text-xs rounded {{ $transaction->type == 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ strtoupper($transaction->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            {{ $transaction->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $transaction->previous_stock }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $transaction->new_stock }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $transaction->user->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $transaction->remarks ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">No transactions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection