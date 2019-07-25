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
                    'type'     => $this->product->jenis_product ?? null,
                    'category' => $this->product->kategori_product ?? null,
                    'price'    => $this->product_detail->harga ?? null,
                ]
                // $this->filtered($this)
            ]
        ];
    }

    protected function filtered($customer)
    {
        $collect = collect(['order' => $customer->no_order]);
        $filtered = $collect->filter(function ($value, $key) {
            return $value == 21394;
        });

        $tc = collect([$filtered]);

        dd($tc);
    }
}
