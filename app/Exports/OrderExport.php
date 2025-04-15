<?php

namespace App\Exports;

// use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\excel\Concerns\WithHeadings;    
use Maatwebsite\Excel\Concerns\WithMapping; 

class OrderExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return 'return';
    }
    

}
