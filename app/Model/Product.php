<?php

namespace App\Model;

use App\Model\Branch;
use App\Model\BranchProduct;
use App\Model\ProductDetails;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function details()
    {
        return $this->hasOne(ProductDetails::class);
    }

    public function branch()
    {
        return $this->hasOne(Branch::class, 'id');
    }

    public function branch_product()
    {
        return $this->hasOne(BranchProduct::class);
    }
}
