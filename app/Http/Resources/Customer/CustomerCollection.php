<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\Resource;

class CustomerCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this->branch);
        // return parent::toArray($request);
        return [
            "customer_order" => [
                'uniqid'     => $this->id,
                'branches'   => $this->branch->nama_cabang ?? null,
                'customer'   => $this->nama_customer,
                'type'       => $this->order->jenis_product ?? null,
                'qty'        => $this->order->qty ?? null,
                'total_sales'=> $this->order->total_pembelian ?? null
            ],
            "customer_detail"=> [
                'address'    => $this->alamat,
                'telphone'   => $this->telpon,
                'company'    => $this->perusahaan
            ]
        ];
    }
}
