<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        dd($this->order);
        // return parent::toArray($request);
        return [
            'uniqid'  => $this->id,
            'no_cust' => $this->kode_customer,
            'customer'=> $this->nama_customer,
            'address' => $this->alamat,
            'telphone'=> $this->telpon,
            'company' => $this->perusahaan,
            'debt'    => [
                'branch' => $this->branch->nama_cabang ?? '',
                'desc'   => $this->piutang->ket ?? '',
                'saldo'  => $this->piutang->saldo ?? null,
            ]
        ];
    }
}
