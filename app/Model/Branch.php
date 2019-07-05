<?php

namespace App\Model;

use App\Model\Branch;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public function index()
    {
        return Branch::all();
    }
}
