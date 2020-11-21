<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Order;

class OrderByShippedSheet implements FromCollection, WithTitle, WithHeadings
{
    public $isShipped;

    public function __construct($isShipped)
    {
        $this->isShipped = $isShipped;
    }

    public function headings(): array
    {
        return Schema::getColumnListing('orders');
    }

    public function collection()
    {
        return Order::where('is_shipped', $this->isShipped)->get();
    }

    public function title(): string
    {
        return $this->isShipped ? '已運送' : '尚未運送';
    }
}
