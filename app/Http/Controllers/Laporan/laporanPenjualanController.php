<?php

namespace App\Http\Controllers\Laporan;

use PDF;
use App\Model\Order;
use App\Model\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class laporanPenjualanController extends Controller
{
    public function index($dates, $product = null)
    {
        $data = explode(",", $dates);
        $date = collect($data)->flatten();
        
        $data = Order::whereBetween('tanggal', [$date[0], $date[1]])
                        ->with(['order_detail' => function ($query) {
                            $query->select('id','order_id','product_id','qty','total_pembelian')
                                ->with(['product' => function ($query) {
                                    $query->select('id','nama_product')
                                                ->with(['productDetail' => function ($query) {
                                                    $query->select('id','product_id','harga','penjualan');
                                                }]);
                                }]);
                        }])
                        ->orderBy('tanggal', 'ASC')
                        ->orderBy('no_order', 'ASC')
                        ->get();
        // dd($data);
        $laporan = collect($data);
        
        $penjualan = $laporan->groupBy(function($item, $key){
            return $item['tanggal'];
        });
        
        $sub = $data->map(function($item, $key) {
            return $item['order_detail']->map(function($value, $index) {
                return $value['total_pembelian'];
            });
        });

        $total = collect($sub)->flatten()->reduce(function($carry, $item) {
            return $carry + $item;
        });
        
        $subtotal = [];
        foreach($penjualan as $key => $value){
            $subtotal[] = $value->map(function($item, $key) {
                return $item['order_detail']->map(function($value,$key) {
                    return $value['total_pembelian'];
                });
            });
        }

        $substotal = [];
        foreach(collect($subtotal) as $key => $value){
            $substotal[] = collect($value)->flatten()->sum();
        }

        // dump($test);
        $option = [
            'data' => $penjualan,
            'from' => $date[0],
            'to'   => $date[1],
            'subtotal' => $substotal,
            'total' => $total,
            'no' => 0,
        ];
        
        $pdf = PDF::LoadView('print.laporan_penjualan', $option);
        return $pdf->setOption('page-size', 'A4')
                    ->setOrientation('landscape')
                    ->setOption('margin-bottom', '1cm')
                    ->setOption('margin-left', '2cm')
                    ->setOption('margin-right', '2cm')
                    ->setOption('margin-top', '1cm')
                    ->setOption('footer-right', 'Hal : [page] / [toPage]')
                    ->setOption('footer-font-size', 8)
                    ->stream('dompdf.pdf', array("attachment" => false));
    }
}
