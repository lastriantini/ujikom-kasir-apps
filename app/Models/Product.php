<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'name',
        'price',
        'stock',
        'image',
    ];

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class);
    }
}
