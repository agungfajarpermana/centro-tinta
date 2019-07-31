<?php

namespace App\Http\Controllers\Laporan;

use PDF;
use App\Model\Piutang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class laporanPiutangController extends Controller
{
    public function index($dates, $customer = null)
    {
        $dates = explode(",",$dates);
        
        if($dates[0]){
            $date = collect($dates)->flatten();
            
            $data = Piutang::whereBetween('tgl', [$date[0], $date[1]])
                             ->with(['orders' => function ($query) use ($customer) {
                                 $query->with(['customer' => function ($query) use ($customer) {
                                            if($customer != 'null'){
                                                $query->where('nama_customer', 'LIKE', '%'.$customer.'%');
                                            }
                                       }]);
                             }])
                             ->orderBy('tgl', 'ASC')
                             ->orderBy('jenis', 'ASC')
                             ->get();
        }

        $laporan = collect($data);

        $piutang = $laporan->groupBy(function ($item,$key) {
            return $item['orders']['customer']['nama_customer'];
        });

        $filter = $piutang->filter(function ($value, $key) {
            return $key !== '';
        });

        $all = $data->map(function ($item, $key) {
            return $item['nominal'];
        });

        //  total utang seluruh data
        $total = $all->reduce(function($carry, $item) {
            return $carry + $item;
        });

        // dd($total);
        $options = [
            'data' => $filter,
            'from' => $date[0],
            'to'   => $date[1],
            'total'=> ($total > 0 ? -$total : $total)
        ];
        // dd($kredit);
        $pdf = PDF::loadView('print.laporan_piutang', $options);
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
