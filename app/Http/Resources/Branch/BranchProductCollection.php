<?php

namespace App\Http\Resources\Branch;

use Illuminate\Http\Resources\Json\Resource;

class BranchProductCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dump($this->productDetail->harga);
        // return parent::toArray($request);
        return [
            'detail_stock'  => [
                'first_stock'   => $this->stok_awal,
                'income_stock'  => $this->stok_masuk,
                'stock_out'     => $this->stok_keluar,
                'last_stock'    => $this->stok_akhir,
            ],
            'detail_produk' => [
                'product'       => $this->product->nama_product,
                'type'          => $this->product->jenis_product,
                'category'      => $this->product->kategori_product,
                'description'   => $this->product->detail_product,
                'price'         => $this->productDetail->harga ?? null,
                'sales'         => $this->productDetail->penjualan ?? null
            ],
            'detail_branch' => [
                'branch'    => $this->branch->nama_cabang,
                'address'   => $this->branch->alamat,
                'telphone'  => $this->branch->telpon,
                'fax'       => $this->branch->fax,
                'email'     => $this->branch->email,
                'leader'    => $this->branch->kepala_cabang
            ]
        ];
    }
}
