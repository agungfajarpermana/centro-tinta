<?php

namespace App\Http\Controllers\API;

use PDF;
use Carbon\Carbon;
use App\Model\Order;
use App\Model\Piutang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Piutang\PiutangCollection as Piutangs;

class PiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($dates = null)
    {
        $dates = explode(",",$dates);
        
        if($dates[0]){
            $collect = collect($dates)->flatten();
            
            $data = Piutangs::collection(
                    Piutang::whereBetween('tgl', [$collect[0], $collect[1]])
                             ->where('kode', '12000001')->get()
            );
        }else{
            $data = Piutangs::collection(Piutang::all());
        }

        $pdf = PDF::loadView('print.laporan_piutang', compact('data'));
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
        $order = Order::where('no_order', $request->order)->first();

        if($order){
            // 12000001 (GUEST LADGER)
            // 11500001 (BNI)
            // 11500002 (BII)
            // 11500003 (BCA)
            // 11500004 (MANDIRI)
            // K = Kredit

            if($request->bank){
                switch ($request->bank) {
                    case 'BCA':
                        $kode = '11500003';
                        break;
    
                    case 'BNI':
                        $kode = '11500001';
                        break;
    
                    case 'BII':
                        $kode = '11500002';
                        break;
    
                    case 'MANDIRI':
                        $kode = '11500004';
                        break;
                }
            }else{
                $kode = '12000001';
            }
            
            $piutang = Piutang::where('order_id', $order->id)->where('customer_id', $order->customer_id)
                                ->where('jenis', 'D')->first();

            if($piutang){
                $create = Piutang::create([
                    'tgl'           => Carbon::now()->format('Y-m-d'),
                    'order_id'      => $order->id,
                    'customer_id'   => $order->customer_id,
                    'nominal'       => str_replace('.','',$request->bayar),
                    'kode'          => $kode,
                    'jenis'         => 'K',
                    'ket'           => $request->ket.' '.'('.($request->bank ? $request->bank : $request->metode).')' ?? null,
                    'saldo'         => ($piutang ? $piutang->saldo - str_replace('.','',$request->bayar) : str_replace('.','',$request->bayar))
                ]);
    
                if($create){
                    return response()->json([
                        'status' => true,
                        'msg'    => 'Data berhasil disimpan!'
                    ]);
                }
            }else{
                return response()->json([
                    'status' => false,
                    'msg'    => 'Silahkan lakukan konfirmasi terlebih dahulu, bahwa barang sudah diterima ke pelanggan!'
                ]);
            }
        }else{
            return response()->json([
                'status' => false,
                'msg'    => 'No. order tidak ditemukan!, Silahkan masukan data yang benar'
            ]);
        }
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
