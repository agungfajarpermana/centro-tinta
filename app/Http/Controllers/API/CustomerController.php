<?php

namespace App\Http\Controllers\API;
use Carbon\Carbon;

use DB;
use App\Model\Order;
use App\Model\Branch;
use App\Model\Piutang;
use App\Model\Customer;
use Illuminate\Http\Request;
use App\Model\ProductDetails;
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
                $product = collect($request->products);
                $branchProduct = Branch::findOrFail(1);
                
                // create data customer order in table order
                $order = Order::create([
                    'tanggal'        => Carbon::now()->format('Y-m-d'),
                    'no_order'       => $request->order,
                    'branch_id'      => 1,
                    'customer_id'    => $request->customerId,
                ]);

                $data = $product->map(function($item, $key) use ($order, $branchProduct) {
                    
                    // create data order detail
                    $order->order_detail()->create([
                        'product_id'     => $item['detail_product']['uniqid'],
                        'qty'            => $item['numberOfPurchases'],
                        'total_pembelian'=> $item['detail_product']['price'] * $item['numberOfPurchases']
                    ]);
                    
                    // get stock branch product
                    $stock = $branchProduct->branch_product()->where('branch_id', $item['detail_branch']['uniqid'])
                                           ->where('product_id', $item['detail_product']['uniqid'])
                                           ->first();

                    // get data penjualan product detail
                    $productDetail = ProductDetails::where('product_id', $item['detail_product']['uniqid'])->first();
                    
                    // update stock branch product
                    $branchProduct->branch_product()->where('branch_id', $item['detail_branch']['uniqid'])
                          ->where('product_id', $item['detail_product']['uniqid'])
                          ->update([
                                'stok_keluar' => ($stock->stok_keluar + $item['numberOfPurchases']),
                                'stok_akhir'  => ($stock->stok_akhir - $item['numberOfPurchases'])
                          ]);

                    // update data penjualan product detail
                    $updateProductDetail = $productDetail->update([
                        'penjualan' => ($productDetail->penjualan + $item['numberOfPurchases'])
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
