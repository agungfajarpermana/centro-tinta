<?php

namespace App\Http\Controllers\API;

use App\Model\Piutang;
use App\Model\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\Customer\CustomerPiutangResource;
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
        $piutang = Piutang::where('customer_id', $customer)->where('saldo', '>', 0)
                            ->orderBy('id', 'DESC')
                            ->first();

        if($piutang){
            return new CustomerPiutangResource(
                $piutang
            );
        }
        
        return new CustomerResource(Customer::where('id', $customer)->first());
        
    }

    public function getDataCustomer()
    {
        return Customer_::collection(Customer::get());
    }
}
