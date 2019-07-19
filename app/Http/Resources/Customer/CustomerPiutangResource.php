<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerPiutangResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this->orders);
        // return parent::toArray($request);
        return [
            'uniqid'   => $this->id,
            'no_cust'  => $this->customer->kode_customer,
            'customer' => $this->customer->nama_customer,
            'address'  => $this->customer->alamat,
            'telephone'=> $this->customer->telpon,
            'company'  => $this->customer->perusahaan,
            'debt'  => [
                'branch'=> $this->branch->nama_cabang,
                'desc'  => $this->ket,
                'saldo' => $this->saldo
            ],
            'product' => [
                'item' => $this->orders->product->nama_product,
                'type' => $this->orders->product->jenis_product,
                'harga'=> $this->orders->product->productDetail->harga
            ]
        ];
    }
}
