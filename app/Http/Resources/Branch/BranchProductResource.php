<?php

namespace App\Http\Resources\Branch;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'branch'  => $this->nama_cabang,
            'address' => $this->alamat,
            'telphone'=> $this->telpon,
            'email'   => $this->email,
            'fax'     => $this->fax,
            'leader'  => $this->kepala_cabang
        ];
    }
}
