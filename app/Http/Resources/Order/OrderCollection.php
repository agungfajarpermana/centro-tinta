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
                'date'     => $this->tanggal,
                'order'    => $this->no_order,
                'branches' => $this->branch->nama_cabang ?? null,
                'customer' => $this->customer->nama_customer,
            ]
        ];
    }
}
