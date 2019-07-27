<?php

namespace App\Http\Controllers\API;

use DB;
use App\Model\Order;
use App\Model\Product;
use App\Model\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderCollection as Orders;
use App\Http\Resources\Product\ProductCollection as Products;
use App\Http\Resources\Order\OrderCustomerCollection as OrderCustomer;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($search = null)
    {
        if(!$search){
            $data = Order::where('branch_id', 1)->orderBy('id', 'ASC')->get();
            $group = collect($data)->groupBy('no_order')->paginate(8);

            // return response()->json(['data' => $group]);
            return Orders::collection(Order::where('branch_id', 1)->orderBy('id','DESC')->paginate(8));
        }
        
        return Orders::collection(Order::where('branch_id', 1)->where('no_order', 'LIKE', '%'.$search.'%')
                        ->orderBy('id', 'DESC')->paginate(8));
    }

    public function customerSales($orders = null)
    {
        $itemCust = OrderCustomer::collection(collect(OrderDetail::where('order_id', $orders)->get()));

        return response()->json([
            'status' => true,
            'data' => $itemCust
        ]);
    }

    public function orderEdit()
    {
        $product = Products::collection(Product::where('branch_id', 1)->orderBy('nama_product', 'ASC')->get());

        return response()->json([
            'status' => true,
            'data' => $product
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->qty == ''){
            $data = OrderDetail::where('id', $id)->update([
                'product_id' => $request->product,
                'total_pembelian' => $request->price
            ]);
        }else{
            $data = OrderDetail::where('id', $id)->update([
                'qty' => $request->qty,
                'total_pembelian' => ($request->qty * $request->price)
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
