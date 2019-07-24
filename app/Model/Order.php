<?php

namespace App\Model;

use App\Model\Branch;
use App\Model\Product;
use App\Model\Customer;
use App\Model\ProductDetails;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded= ['created_at','updated_at'];
    protected $hidden = ['created_at','updated_at'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function product_detail()
    {
        return $this->belongsTo(ProductDetails::class, 'product_id', 'id');
    }
}
