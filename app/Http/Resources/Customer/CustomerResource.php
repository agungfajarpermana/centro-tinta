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
        // dd($this->nama_customer);
        return parent::toArray($request);
        return [
            'id'      => $this->id,
            'name'    => $this->nama_customer,
            'address' => $this->alamat,
            'telphone'=> $this->telpon,
            'company' => $this->perusahaan
        ];
    }
}
