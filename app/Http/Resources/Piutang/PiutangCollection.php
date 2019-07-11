<?php

namespace App\Http\Resources\Piutang;

use Illuminate\Http\Resources\Json\Resource;

class PiutangCollection extends Resource
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
            'uniqid'        => $this->id,
            'date'          => $this->tgl,
            'order'         => $this->orders->no_order,
            'code'          => $this->kode,
            'nominals'      => $this->nominal,
            'type'          => $this->jenis,
            'description'   => $this->ket,
            'saldo'         => $this->saldo
        ];
    }
}
