<?php 

namespace App\Exports;

use App\Model\Product;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductsSheet implements WithTitle, ShouldAutoSize, WithHeadings, WithEvents, FromArray
{
    private $items;
    private $kode;

    public function __construct(string $items)
    {
        $this->items = $items;
    }

    public function registerEvents(): array
    {
        $styleArray = [
            'font' => [
                'bold' => true
            ]
        ];

        return [
            // Handle by a closure.
            AfterSheet::class => function (AfterSheet $event) use ($styleArray) {
                $event->sheet->getStyle('A1:C1')->applyFromArray($styleArray);
            }
        ];
    }

    public function array(): array
    {
        return $sheetArray = [
            ['DE-30-K 80ml (example)',40000, 12]
        ];
    }

    public function headings(): array
    {
        return [
            'Products',
            'Price',
            'Stock',
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->items;
    }
}