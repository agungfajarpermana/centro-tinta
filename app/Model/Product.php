<?php

namespace App\Model;

use App\Model\ProductDetails;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function details()
    {
        return $this->hasOne(ProductDetails::class);
    }
}
