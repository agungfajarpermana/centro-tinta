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
        // return parent::toArray($request);
        return [
            'product'       => $this->nama_product,
            'price'         => $this->harga,
            'stock'         => $this->stok,
            'description'   => $this->detail_product,
            'type'          => $this->jenis_product,
            'href'          => [
                'detail' => route('products.show', $this->id)
            ]
        ];
    }
}
