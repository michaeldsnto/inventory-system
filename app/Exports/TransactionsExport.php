<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Transaction::with(['item', 'user']);

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('transaction_date', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('transaction_date', '<=', $this->filters['date_to']);
        }

        return $query->orderBy('transaction_date', 'desc');
    }

    public function headings(): array
    {
        return [
            'Transaction #',
            'Date',
            'Item',
            'Type',
            'Quantity',
            'Previous Stock',
            'New Stock',
            'User',
            'Remarks',
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->transaction_number,
            $transaction->transaction_date->format('Y-m-d H:i'),
            $transaction->item->name,
            strtoupper($transaction->type),
            $transaction->quantity,
            $transaction->previous_stock,
            $transaction->new_stock,
            $transaction->user->name,
            $transaction->remarks,
        ];
    }
}