<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\Resource;

class OrderCollection extends Resource
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
            "customer_order" => [
                'uniqid'   => $this->id,
                'order'    => $this->no_order,
                'branches' => $this->branch->nama_cabang,
                'customer' => $this->customer->nama_customer,
                'qty'      => $this->qty,
                'total_sales' => $this->total_pembelian,
                'detail_item' => [
                    'product'  => $this->product->nama_product ?? null,
                    'type'     => $this->product->jenis_product,
                    'category' => $this->product->kategori_product,
                    'price'    => $this->product_detail->harga,
                ]
            ]
        ];
    }

    protected function filtered($customer)
    {
        $cv = array_count_values($customer->pluck('no_order')->toArray());
       
        return collect($cv)->map(function ($v, $k) use ($customer) {
            return [
                'no_order'   => $k,
                'count_item' => $v
            ];
        })->values();
    }
}
