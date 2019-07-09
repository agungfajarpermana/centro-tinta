<?php

namespace App\Model;

use App\Model\Order;
use App\Model\Branch;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $hidden = ['created_at','updated_at'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id');
    }
}
