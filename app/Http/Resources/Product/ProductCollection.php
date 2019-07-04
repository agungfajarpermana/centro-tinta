<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\Resource;

class ProductCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this->details);
        // return parent::toArray($request);
        return [
            'product'       => $this->nama_product,
            'description'   => $this->detail_product,
            'type'          => $this->jenis_product,
            'category'      => $this->kategori_product,
            'detail'        => [
                'harga' => $this->details->harga ?? null,
                'uniqid'=> $this->product_id ?? null
            ]
        ];
    }
}
