@extends('layouts.app')

@section('title', 'New Transaction')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Record Stock Transaction</h2>

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Item *</label>
                    <select name="item_id" id="item_id" required class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Select Item</option>
                        @foreach($items as $item)
                        <option value="{{ $item->id }}" data-stock="{{ $item->quantity }}">
                            {{ $item->name }} (SKU: {{ $item->sku }}) - Current Stock: {{ $item->quantity }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Transaction Type *</label>
                    <select name="type" id="type" required class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Select Type</option>
                        <option value="in">Stock In (Receive)</option>
                        <option value="out">Stock Out (Issue)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                    <input type="number" name="quantity" id="quantity" required min="1"
                        class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <p id="stock-warning" class="text-sm text-red-600 mt-1 hidden">Insufficient stock available!</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                    <textarea name="remarks" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('transactions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit" id="submit-btn" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Record Transaction
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const itemSelect = document.getElementById('item_id');
    const typeSelect = document.getElementById('type');
    const quantityInput = document.getElementById('quantity');
    const stockWarning = document.getElementById('stock-warning');
    const submitBtn = document.getElementById('submit-btn');

    function validateStock() {
        const selectedOption = itemSelect.options[itemSelect.selectedIndex];
        const currentStock = parseInt(selectedOption.getAttribute('data-stock') || 0);
        const type = typeSelect.value;
        const quantity = parseInt(quantityInput.value || 0);

        if (type === 'out' && quantity > currentStock) {
            stockWarning.classList.remove('hidden');
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            stockWarning.classList.add('hidden');
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    itemSelect.addEventListener('change', validateStock);
    typeSelect.addEventListener('change', validateStock);
    quantityInput.addEventListener('input', validateStock);
});
</script>
@endsection