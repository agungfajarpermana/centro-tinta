<?php

namespace App\Imports;

use App\Model\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    use Importable;
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $product = Product::create([
            'branch_id'         => 1,
            'nama_product'      => $row['products'],
            'jenis_product'     => 'Tinta Printer',
            'kategori_product'  => 'Tinta',
            'detail_product'    => 'ini dekripsi tentang product'
        ]);

        $product->productDetail()->create([
            'harga'     => str_replace('.','',$row['price']),
            'penjualan' => 0
        ]);

        $branch = $product->branchProduct()->create([
            'branch_id'    => 1,
            'stok_awal'    => $row['stock'],
            'stok_masuk'   => $row['stock'],
            'stok_keluar'  => 0,
            'stok_akhir'   => $row['stock']
        ]);
        
        return;
    }
}
