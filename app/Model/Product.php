<?php

namespace App\Model;

use App\Model\Branch;
use App\Model\BranchProduct;
use App\Model\ProductDetails;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['created_at','updated_at'];
    protected $hidden = ['created_at','updated_at'];
    
    public function productDetail()
    {
        return $this->hasOne(ProductDetails::class);
    }

    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function branchProduct()
    {
        return $this->hasOne(BranchProduct::class);
    }
}
