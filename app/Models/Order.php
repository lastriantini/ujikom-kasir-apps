<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{    
    protected $fillable = [
        'staff_id',
        'total_price',
        'member_id',
        'total_pay',
        'total_return',
        'poin',
        'total_poin',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
    public function detailOrder()
    {
        return $this->hasMany(DetailOrder::class);
    }
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
