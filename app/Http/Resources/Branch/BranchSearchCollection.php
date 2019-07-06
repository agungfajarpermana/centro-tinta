<?php

namespace App\Http\Resources\Branch;

use Illuminate\Http\Resources\Json\Resource;

class BranchSearchCollection extends Resource
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
            "detail_branch"  => [
                'uniqid'    => $this->branch->id,
                'branch'    => $this->branch->nama_cabang,
                'address'   => $this->branch->alamat,
                'telphone'  => $this->branch->telpon,
                'fax'       => $this->branch->fax,
                'email'     => $this->branch->email,
                'leader'    => $this->branch->kepala_cabang
            ],
            "detail_product" => [
                'product'       => $this->nama_product,
                'type'          => $this->jenis_product,
                'category'      => $this->kategori_product,
                'description'   => $this->detail_product,
                'price'         => $this->details->harga,
                'sales'         => $this->details->penjualan
            ],
            "detail_stock" => [
                'first_stock' => $this->branch_product->stok_awal,
                'income_stock'=> $this->branch_product->stok_masuk,
                'stock_out'   => $this->branch_product->stok_keluar,
                'last_stock'  => $this->branch_product->stok_akhir
            ]
        ];
    }
}
