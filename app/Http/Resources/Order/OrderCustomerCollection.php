<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\Resource;

class OrderCustomerCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this->product);
        // return parent::toArray($request);
        return [
            'uniqid'  => $this->id,
            'prod_id' => $this->product->id ?? null,
            'branch_id' => $this->product->branch_id,
            'product' => $this->product->nama_product ?? null,
            'type'    => $this->product->jenis_product ?? null,
            'qty'     => $this->qty,
            'total'   => $this->total_pembelian,
        ];
    }
}
