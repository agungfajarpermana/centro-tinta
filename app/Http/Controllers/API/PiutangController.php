<?php

namespace App\Http\Controllers\API;

use PDF;
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

        return $data;
        // $pdf = PDF::loadView('print.laporan_piutang', compact('data'));
        // return $pdf->setOption('page-size', 'A4')
        //             ->setOrientation('landscape')
        //             ->setOption('margin-bottom', '1cm')
        //             ->setOption('margin-left', '2cm')
        //             ->setOption('margin-right', '2cm')
        //             ->setOption('margin-top', '1cm')
        //             ->setOption('footer-right', 'Hal : [page] / [toPage]')
        //             ->setOption('footer-font-size', 8)
        //             ->stream();
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
