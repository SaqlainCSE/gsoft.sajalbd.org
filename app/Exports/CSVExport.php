<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class CSVExport implements FromView, WithColumnFormatting
{
    public $view;
    public $data;
    public $columnFormats;

    public function __construct($view, $data, $columnFormats=[])
    {
        $this->view = $view;
        $this->data = $data;
        $this->columnFormats=$columnFormats;
    }

    public function columnFormats(): array
    {
        return $this->columnFormats;
    }

    public function view(): View
    {
        return view($this->view, $this->data);
    }
}