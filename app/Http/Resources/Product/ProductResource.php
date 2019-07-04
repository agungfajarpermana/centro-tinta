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
            'price'         => $this->details->harga ?? 0,
            'type'          => $this->jenis_product,
            'sales'         => $this->details->penjualan ?? 0
        ];
    }
}
