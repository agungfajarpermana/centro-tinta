<?php

namespace App\Model;

use App\Model\Branch;
use App\Model\Product;
use App\Model\productDetail;
use Illuminate\Database\Eloquent\Model;

class BranchProduct extends Model
{
    protected $guarded = ['created_at','updated_at'];
    protected $hidden = ['created_at','updated_at'];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productDetail()
    {
        return $this->belongsTo(ProductDetails::class, 'product_id', 'product_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
