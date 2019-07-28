<?php

namespace App\Exports;

use App\Model\Product;
use App\Exports\ProductsSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ProductsExport implements WithStrictNullComparison, WithMultipleSheets
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return '';
    }

    public function sheets(): array
    {
        $items = ['PRODUCTS'];

        foreach($items as $key => $item){
            $sheets[] = new ProductsSheet($item);
        }

        return $sheets;
    }
}
