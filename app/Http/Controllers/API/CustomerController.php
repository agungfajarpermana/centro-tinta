<?php

namespace App\Http\Controllers\API;

use App\Model\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\CustomerCollection as Customers;

class CustomerController extends Controller
{
    public function index()
    {
        return Customers::collection(Customer::paginate(8));
    }
}
