<?php

namespace App\Model;

use App\Model\BranchProduct;
use App\Model\productDetail;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $guarded = ['created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];

    public function branch_product()
    {
        return $this->hasOne(BranchProduct::class);
    }
}
