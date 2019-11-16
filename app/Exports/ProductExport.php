<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    use Exportable;
    private $data;
    private $headings;

    //数据注入
    public function __construct($data,$headings)
    {
        $this->data = $data;
        $this->headings = $headings;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //实现FromCollection接口
        return collect($this->data);
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return $this->headings;
    }


}
