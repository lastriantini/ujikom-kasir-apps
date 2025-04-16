<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'name',
        'address',
        'no_telp',
        'poin',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
