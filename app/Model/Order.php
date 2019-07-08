<?php

namespace App\Model;

use App\Model\Branch;
use App\Model\Customer;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
