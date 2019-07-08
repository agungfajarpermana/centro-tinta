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
        // dd($this->details);
        // return parent::toArray($request);
        return [
            'detail_branch' => [
                'branch'    => $this->branch->nama_cabang,
                'address'   => $this->branch->alamat,
                'telphone'  => $this->branch->telpon,
                'fax'       => $this->branch->fax,
                'email'     => $this->branch->email,
                'leader'    => $this->branch->kepala_cabang
            ],
            'detail_product' => [
                'uniqid'        => $this->id,
                'product'       => $this->nama_product,
                'type'          => $this->jenis_product,
                'category'      => $this->kategori_product,
                'description'   => $this->detail_product,
                'price'         => $this->productDetail->harga ?? null,
                'sales'         => $this->productDetail->penjualan ?? null
            ],
            'detail_stock'  => [
                'first_stock'   => $this->branchProduct->stok_awal,
                'income_stock'  => $this->branchProduct->stok_masuk,
                'stock_out'     => $this->branchProduct->stok_keluar,
                'last_stock'    => $this->branchProduct->stok_akhir,
            ]
        ];
    }
}
