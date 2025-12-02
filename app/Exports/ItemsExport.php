<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Item::with(['category', 'supplier'])->get();
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Name',
            'Category',
            'Supplier',
            'Quantity',
            'Min Stock',
            'Unit Price',
            'Total Value',
            'Status',
        ];
    }

    public function map($item): array
    {
        return [
            $item->sku,
            $item->name,
            $item->category->name,
            $item->supplier->name,
            $item->quantity,
            $item->min_stock_level,
            $item->unit_price,
            $item->quantity * $item->unit_price,
            $item->isLowStock() ? 'Low Stock' : 'In Stock',
        ];
    }
}