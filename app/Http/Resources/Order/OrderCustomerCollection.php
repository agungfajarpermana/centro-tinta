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
            // 'product' => $this->product->nama_product,
            // 'type'    => $this->product->jenis_product,
            // 'qty'     => $this->qty,
            'total'   => $this->total_pembelian,
            $this->groupItems($this)
        ];
    }

    protected function groupItems($products)
    {
        $cv = array_count_values($products->pluck('product_id')->toArray());
        $ct = array_count_values($products->pluck('total_pembelian')->toArray());
       
        return collect($cv)->map(function ($v, $k) use ($ct) {
            return collect($ct)->map(function ($t, $i) use ($v, $k) {
                return ['product' => $k, 'qty' => $v, 'total' => ($i + $k)];
            })->values()->first();
        })->values()->first();
    }
}
