<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'product'       => $this->nama_product,
            'price'         => ($this->details ? $this->details->harga : null),
            'type'          => $this->jenis_product,
            'sales'         => ($this->details ? $this->details->penjualan : null)
        ];
    }
}
