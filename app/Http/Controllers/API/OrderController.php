<?php

namespace App\Http\Controllers\API;

use DB;
use App\Model\Order;
use App\Model\Branch;
use App\Model\Product;
use App\Model\Piutang;
use App\Model\OrderDetail;
use App\Model\BranchProduct;
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
            // $group = collect($data)->groupBy('no_order')->paginate(8);

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
    public function destroy(Request $request, $id)
    {
        if(!$request->ajax()) dd('Woow, hayo mau ngapain!');

        try {
            DB::connection()->getPdo();
            DB::beginTransaction();

            try {
                $piutang = Piutang::where('order_id', $id)->where('jenis', 'K')->first();
                
                if(!$piutang){
                    $data   = Order::findOrFail($id);
                    $order  = $data->order_detail()->where('order_id', $id)->get();
                    $orders = collect($order);

                    $branch = Branch::where('id', $data->branch_id)->first();
                    
                    $orders->each(function ($item, $key) use ($data, $branch) {
                        $stock = $branch->branch_product()->where('product_id', $item->product_id)->first();
                        return BranchProduct::where('branch_id', $data->branch_id)->where('product_id', $item->product_id)->update([
                            'stok_keluar'   => ($stock->stok_keluar - $item->qty),
                            'stok_akhir'    => ($stock->stok_akhir + $item->qty)
                        ]);
                    });

                    $delete = $data->delete();

                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'msg' => 'Data berhasil di hapus!'
                    ]);
                }else{
                    return response()->json([
                        'status' => false,
                        'msg' => 'Data GAGAL dihapus, Karena pelanggan ini sudah melakukan pembayaran!'
                    ]);
                }

            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'status' => false,
                    'msg'    => 'Ada masalah saat melakukan delete data',
                    'error'  => $e->getMessage()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'    => false,
                'msg'       => 'Koneksi ke database terputus',
                'error'     => $e->getMessage()
            ]);
        }
    }

    public function orderDelete(Request $request)
    {
        if(!$request->ajax()) dd('Woow, Hayo mau ngapain!');

        try {
            DB::connection()->getPdo();
            DB::beginTransaction();

            try {
                $data    = OrderDetail::findOrFail($request->id);
                $product = BranchProduct::where('product_id', $data->product_id)->first();

                $branch = BranchProduct::where('id', $data->product_id)->update([
                    'stok_keluar'=> ($product->stok_keluar - $data->qty),
                    'stok_akhir' => ($product->stok_akhir - $data->qty)
                ]);
                
                $delete =  $data->delete();

                DB::commit();

                return response()->json([
                    'status' => true,
                    'msg'  => 'Data berhasil di hapus!'
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'status' => false,
                    'msg'    => 'Ada masalah saat melakukan delete data',
                    'error'  => $e->getMessage()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'msg'     => 'Koneksi ke database terputus!',
                'error'   => $e->getMessage()
            ]);
        }
    }
}
