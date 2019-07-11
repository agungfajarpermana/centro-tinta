<?php

namespace App\Http\Controllers\API;

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
        return view('print.laporan_piutang');
        $dates = explode(",",$dates);
        
        if($dates[0]){
            $collect = collect($dates)->flatten();
            
            return Piutangs::collection(
                    Piutang::whereBetween('tgl', [$collect[0], $collect[1]])
                             ->where('kode', '12000001')->get()
            );
        }
        return Piutangs::collection(Piutang::all());
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
