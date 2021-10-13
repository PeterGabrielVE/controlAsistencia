<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Asistencia;
use App\Models\Assignment;
use App\Models\Turn;
use DB;

class ReportController extends Controller
{
    public function __construct()
    {
        set_time_limit(8000000);
    }

    public function index()
    {
        $asistencia = Asistencia::orderBy('fecha','DESC')->get();
        return view('pages.report.index',compact('asistencia'));
    }

    public function report_jornada(){

        ini_set('max_execution_time', 300);
        set_time_limit(0);
        $asistencia = DB::table('jornada')->get();
        $primer = DB::table('jornada')->first();
        $ultimo = DB::table('jornada')->orderBy('fecha', 'desc')->first();
        $inicio = strtotime($primer->fecha);
        $final = strtotime($ultimo->fecha."+ 1 days");

        //dd($asistencia);

        return view('pages.report.jornada',compact('asistencia','inicio','final'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function report_asistencia()
    {
        $asistencia = Asistencia::where('id_user', Auth::user()->id)->orderBy('fecha','DESC')->get();
        return view('pages.report.index',compact('asistencia'));
    }

    public function report_empleados()
    {

        $grupos = DB::table('groups_users')->where('id_user', Auth::user()->id)->pluck('id_group');

        $asistencia = Asistencia::leftjoin('users as us','asistencias.id_user','us.id')
                    ->leftjoin('users_groups as ug','us.id','ug.id_user')
                    ->leftjoin('groups as gr','ug.id_group','gr.id')
                    ->select('asistencias.*')
                    ->whereIn('gr.id',$grupos)
                    ->orderBy('asistencias.fecha','DESC')
                    ->get();

        return view('pages.report.index',compact('asistencia'));
    }

    public function report_jornada_by_rol(){

        ini_set('max_execution_time', 300);
        set_time_limit(0);
        $asistencia = DB::table('jornada')->get();

        $grupos = DB::table('groups_users')->where('id_user', Auth::user()->id)->pluck('id_group');

        $asistencia = DB::table('jornada')
                    ->leftjoin('users as us','jornada.usuario','us.id')
                    ->leftjoin('users_groups as ug','us.id','ug.id_user')
                    ->leftjoin('groups as gr','ug.id_group','gr.id')
                    ->select('jornada.*')
                    ->whereIn('ug.id_group',$grupos)
                    ->orderBy('jornada.fecha','DESC')
                    ->get();



        $primer = DB::table('jornada')->first();
        $ultimo = DB::table('jornada')->orderBy('fecha', 'desc')->first();
        $inicio = strtotime($primer->fecha);
        $final = strtotime($ultimo->fecha."+ 1 days");

        //dd($asistencia);

        return view('pages.report.jornada',compact('asistencia','inicio','final'));
    }
}
