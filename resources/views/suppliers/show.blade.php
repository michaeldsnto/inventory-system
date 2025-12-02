@extends('layouts.app')

@section('title', 'Supplier Details')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Supplier Details</h2>
        <div class="space-x-2">
            <a href="{{ route('suppliers.edit', $supplier) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">
                <i class="fas fa-edit mr-1"></i>Edit
            </a>
            <a href="{{ route('suppliers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-1"></i>Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Supplier Information -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Supplier Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-500">Name</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $supplier->name }}</p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-500">Email</label>
                    <p class="text-lg text-gray-900">{{ $supplier->email }}</p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-500">Phone</label>
                    <p class="text-lg text-gray-900">{{ $supplier->phone ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-500">Contact Person</label>
                    <p class="text-lg text-gray-900">{{ $supplier->contact_person ?? '-' }}</p>
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-medium text-gray-500">Address</label>
                    <p class="text-gray-900">{{ $supplier->address ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-500">Status</label>
                    <p>
                        <span class="px-3 py-1 text-sm rounded-full {{ $supplier->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $supplier->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-500">Total Items</label>
                    <p class="text-2xl font-bold text-indigo-600">{{ $supplier->items->count() }}</p>
                </div>

                <div class="md:col-span-2 grid grid-cols-2 gap-4 pt-4 border-t">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Created At</label>
                        <p class="text-sm text-gray-900">{{ $supplier->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Last Updated</label>
                        <p class="text-sm text-gray-900">{{ $supplier->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Summary</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-3 border-b">
                    <span class="text-gray-600">Total Items</span>
                    <span class="font-semibold text-gray-900">{{ $supplier->items->count() }}</span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b">
                    <span class="text-gray-600">Total Stock Value</span>
                    <span class="font-semibold text-gray-900">
                        ${{ number_format($supplier->items->sum(function($item) {
                            return $item->quantity * $item->unit_price;
                        }), 2) }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Low Stock Items</span>
                    <span class="font-semibold text-red-600">
                        {{ $supplier->items->filter(function($item) {
                            return $item->isLowStock();
                        })->count() }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Supplied Items -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Supplied Items</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Value</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($supplier->items as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $item->sku }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $item->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->category->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm {{ $item->isLowStock() ? 'text-red-600 font-bold' : 'text-gray-900' }}">
                            {{ $item->quantity }} {{ $item->unit }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ number_format($item->unit_price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            ${{ number_format($item->quantity * $item->unit_price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($item->isLowStock())
                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">Low Stock</span>
                            @else
                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">In Stock</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('items.show', $item) }}" class="text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">No items supplied yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection