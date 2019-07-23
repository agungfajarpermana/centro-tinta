<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\Resource;

class OrderCustomerCollection extends Resource
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
            'product' => $this->product->nama_product,
            'type'    => $this->product->jenis_product
        ];
    }

    protected function groupItems($products)
    {
        $cv = array_count_values($products->pluck('nama_product')->toArray());
       
        return collect($cv)->map(function ($v, $k) {
            return ['product' => $k, 'quantity' => $v];
        })->values();
    }
}
