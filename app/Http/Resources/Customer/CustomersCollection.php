<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\Resource;

class CustomersCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'uniqid'      => $this->id,
            'no_customer' => $this->kode_customer,
            'customer'    => $this->nama_customer,
            'address'     => $this->alamat,
            'telphone'    => $this->telpon,
            'company'     => $this->perusahaan
        ];
    }
}
