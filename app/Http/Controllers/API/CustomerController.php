<?php

namespace App\Http\Controllers\API;

use App\Model\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\CustomersCollection as Customer_;
use App\Http\Resources\Customer\CustomerCollection as Customers;

class CustomerController extends Controller
{
    public function index()
    {
        return Customers::collection(Customer::paginate(8));
    }

    public function detailCustomer($customer)
    {
        return Customer::where('id', $customer)->first();
    }

    public function getDataCustomer()
    {
        return Customer_::collection(Customer::get());
    }
}
