<?php

namespace App\Model;

use App\Model\Order;
use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
