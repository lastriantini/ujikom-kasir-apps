<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;    
use Maatwebsite\Excel\Concerns\WithMapping; 

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::with(['member', 'user'])->get();
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->user->name ?? '-',
            $order->member->name ?? '-',
            $order->total_price,
            $order->total_pay,
            $order->total_return,
            $order->poin,
            $order->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function headings(): array
    {
        return ['ID', 'Petugas', 'Nama Pelanggan', 'Total Harga', 'Total Bayar', 'Kembalian', 'Poin Digunakan', 'Tanggal Penjualan'];
    }
    

}
