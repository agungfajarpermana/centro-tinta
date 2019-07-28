<?php

namespace App\Http\Controllers\Laporan;

use PDF;
use App\Model\Order;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class laporanOrdersController extends Controller
{
    public function index($order = null)
    {
        $order   = Order::where('no_order', $order)->orderBy('no_order', 'ASC');
        $product = $order->first();

        foreach($product->order_detail()->get() as $key => $value){
            $order_qty[] = $value->qty;
            $order_detail[] = Product::where('id', $value->product_id)->first();
        }

        // dd($order_qty);
        $options = [
            'data' => $order_detail,
            'order'=> $order->first(),
            'qty'  => $order_qty
        ];

        $pdf = PDF::LoadView('print.laporan_orders', $options);
        return $pdf->setOption('page-size', 'A4')
                    ->setOrientation('landscape')
                    ->setOption('margin-bottom', '1cm')
                    ->setOption('margin-left', '2cm')
                    ->setOption('margin-right', '2cm')
                    ->setOption('margin-top', '1cm')
                    ->setOption('footer-right', 'Hal : [page] / [toPage]')
                    ->setOption('footer-font-size', 8)
                    ->stream();
    }
}
