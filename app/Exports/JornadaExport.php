<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class JornadaExport implements FromView 
{

    private $id;

    public function __construct($asistencia=null)
    {
        $this->id = $asistencia;
    }

    public function view(): view{

        $asistencia = $this->id;
        $primer = DB::table('jornada')->first();
        $ultimo = DB::table('jornada')->orderBy('fecha', 'desc')->first();
        $inicio = strtotime($primer->fecha);
        $final = strtotime($ultimo->fecha."+ 1 days");

        return view("pages.report.reporte_marcaje", compact('asistencia','inicio','final'));


    }
}
