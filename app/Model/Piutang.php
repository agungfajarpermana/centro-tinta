<?php

namespace App\Model;

use App\Model\Order;
use App\Model\Customer;
use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id')
                    ->with(['product' => function ($query) {
                        $query->select('id', 'nama_product', 'jenis_product')
                              ->with(['productDetail' => function ($query) {
                                  $query->select('id', 'product_id', 'harga', 'penjualan');
                              }]);
                    }]);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
