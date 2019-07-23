<?php

namespace App\Http\Controllers\API;

use App\Model\Order;
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
            return Orders::collection(Order::orderBy('id', 'DESC')->paginate(8));
        }
        
        return Orders::collection(Order::where('no_order', 'LIKE', '%'.$search.'%')
                        ->orderBy('id', 'DESC')->paginate(8));
    }

    public function customerSales($orders)
    {
        $itemCust = OrderCustomer::collection(collect(Order::where('no_order', $orders)->get()));
        $order    = $itemCust->groupBy(function ($item, $key) {
            return $item['product_id'];
        });
        die($order);
        return response()->json($order);
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
