<?php

namespace App\Http\Controllers\Laporan;

use PDF;
use App\Model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class laporanOrdersController extends Controller
{
    public function index($order = null)
    {
        $order = Order::where('no_order', $order)->orderBy('no_order', 'ASC');
        
        $options = [
            'data' => $order->get(),
            'order'=> $order->first()
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
