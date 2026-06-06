<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    protected $clients;

    public function __construct($clients)
    {
        $this->clients = $clients;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->clients;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Mobile',
            'District',
            'Zone',
            'Address',
        ];
    }
}
