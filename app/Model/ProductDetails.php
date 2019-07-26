<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductDetails extends Model
{
    protected $guarded = ['created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];
}
