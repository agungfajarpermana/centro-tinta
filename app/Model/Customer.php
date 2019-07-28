<?php

namespace App\Model;

use App\Model\Order;
use App\Model\Branch;
use App\Model\Piutang;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = ['created_at','updated_at'];
    protected $hidden = ['created_at','updated_at'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id');
    }

    public function piutang()
    {
        return $this->belongsTo(Piutang::class, 'customer_id');
    }
}
