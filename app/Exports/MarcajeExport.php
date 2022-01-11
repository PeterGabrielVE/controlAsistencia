<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MarcajeExport implements FromView 
{

    private $id;

    public function __construct($asistencia=null)
    {
        $this->id = $asistencia;
    }

    public function view(): view{

        $asistencia = $this->id;

        return view("pages.report.reporte_marcaje", compact("asistencia"));


    }
}
