<?php

namespace App\Http\Controllers\API;

use DB;
use App\Model\Order;
use App\Model\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderCollection as Orders;
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
            $data = Order::orderBy('id', 'ASC')->get();
            $group = collect($data)->groupBy('no_order')->paginate(8);

            // return response()->json(['data' => $group]);
            return Orders::collection(Order::orderBy('id','DESC')->paginate(8));
        }
        
        return Orders::collection(Order::where('no_order', 'LIKE', '%'.$search.'%')
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
        //
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
