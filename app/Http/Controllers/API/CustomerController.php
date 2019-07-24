<?php

namespace App\Http\Controllers\API;
use Carbon\Carbon;

use DB;
use App\Model\Order;
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

    public function store(Request $request)
    {
        try {
            DB::connection()->getPdo();
            DB::beginTransaction();

            try {
                $order = collect($request->products);

                $data = $order->map(function($item, $key) use ($request) {
                    Order::create([
                        'tanggal'        => Carbon::now()->format('Y-m-d'),
                        'no_order'       => $request->order,
                        'branch_id'      => 1,
                        'customer_id'    => $request->customerId,
                        'product_id'     => $item['detail_product']['uniqid'],
                        'qty'            => $item['numberOfPurchases'],
                        'total_pembelian'=> $item['detail_product']['price'] * $item['numberOfPurchases']
                    ]);
                });

                DB::commit();

                return response()->json([
                    'status' => true,
                    'msg'    => 'Data berhasil disimpan!'
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'status' => false,
                    'msg'    => 'Ada masalah saat memasukan data customer sales!',
                    'error'  => $e->getMessage()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg'    => 'Koneksi ke database terputus!',
                'error'  => $e->getMessage()
            ]);
        }
    }
}
