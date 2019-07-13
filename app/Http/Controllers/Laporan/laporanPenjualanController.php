<?php

namespace App\Http\Controllers\Laporan;

use PDF;
use App\Model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class laporanPenjualanController extends Controller
{
    public function index($dates)
    {
        $data = explode(",", $dates);
        $date = collect($data)->flatten();
        
        $data = Order::whereBetween('tanggal', [$date[0], $date[1]])
                        ->orderBy('tanggal', 'ASC')->orderBy('no_order', 'ASC')->get();
        
        $laporan = collect($data);
        
        $penjualan = $laporan->groupBy(function($item, $key){
            return $item['tanggal'];
        });

        $option = [
            'data' => $penjualan,
            'from' => $date[0],
            'to'   => $date[1]
        ];
        // dd($option);
        $pdf = PDF::LoadView('print.laporan_penjualan', $option);
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
