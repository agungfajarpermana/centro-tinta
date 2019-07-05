<?php

namespace App\Http\Resources\Branch;

use Illuminate\Http\Resources\Json\Resource;

class BranchSearchCollection extends Resource
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
            'product' => $this->nama_product,
            'category'=> $this->kategori_product
        ];
    }
}
