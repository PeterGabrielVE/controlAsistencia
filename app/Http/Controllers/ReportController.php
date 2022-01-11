<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Asistencia;
use App\User;
use App\Models\Assignment;
use App\Models\Turn;
use App\Exports\MarcajeExport;
use App\Exports\JornadaExport;
use DB;
use Excel;

class ReportController extends Controller
{
    public function __construct()
    {
        set_time_limit(8000000);
    }

    public function index()
    {
        $users = User::where('status',1)
        ->select(DB::raw("CONCAT(fullname,' ',last_name) AS name"),'id')
        ->pluck('name','id')->prepend('Seleccionar Todo…', '');
        $asistencia = Asistencia::orderBy('fecha','DESC')->get();
        return view('pages.report.index',compact('asistencia','users'));
    }

    public function report_jornada(){

        ini_set('max_execution_time', 300);
        set_time_limit(0);
        $asistencia = DB::table('jornada')->get();
        $primer = DB::table('jornada')->first();
        $ultimo = DB::table('jornada')->orderBy('fecha', 'desc')->first();
        $inicio = strtotime($primer->fecha);
        $final = strtotime($ultimo->fecha."+ 1 days");
        $users = User::where('status',1)
        ->select(DB::raw("CONCAT(fullname,' ',last_name) AS name"),'id')
        ->pluck('name','id')->prepend('Seleccionar Todo…', '');

        //dd($asistencia);

        return view('pages.report.jornada',compact('asistencia','inicio','final','users'));
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
        $users = User::where('status',1)
        ->select(DB::raw("CONCAT(fullname,' ',last_name) AS name"),'id')
        ->pluck('name','id')->prepend('Seleccionar Todo…', '');

        $asistencia = Asistencia::where('id_user', Auth::user()->id)->orderBy('fecha','DESC')->get();
        return view('pages.report.index',compact('asistencia','users'));
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
        $users = User::where('status',1)
        ->select(DB::raw("CONCAT(fullname,' ',last_name) AS name"),'id')
        ->pluck('name','id')->prepend('Seleccionar Todo…', '');

        $grupos = DB::table('groups_users')->where('id_user', Auth::user()->id)->pluck('id_group');

        $asistencia = DB::table('jornada')
                    ->leftjoin('users as us','jornada.usuario','us.id')
                    ->leftjoin('users_groups as ug','us.id','ug.id_user')
                    ->leftjoin('groups as gr','ug.id_group','gr.id')
                    ->select('jornada.*')
                    ->whereIn('gr.id',$grupos)
                    ->orderBy('jornada.fecha','DESC')
                    ->get();



        $primer = DB::table('jornada')->first();
        $ultimo = DB::table('jornada')->orderBy('fecha', 'desc')->first();
        $inicio = strtotime($primer->fecha);
        $final = strtotime($ultimo->fecha."+ 1 days");

        //dd($asistencia);

        return view('pages.report.jornada',compact('asistencia','inicio','final','users'));
    }

    public function report_filter_marcas(Request $req)
    {
        //dd($req->all());
        if($req->user_id != '' || $req->user_id != null){
            $asistencia = Asistencia::where('id_user',$req->user_id)
                                ->whereBetween('fecha',[$req->since,$req->until])
                                ->orderBy('fecha','DESC')
                                ->get();
        }else{
            $asistencia = Asistencia::whereBetween('fecha',[$req->since,$req->until])
                                ->orWhereBetween('fecha_salida',[$req->since,$req->until])
                                ->orderBy('fecha','DESC')
                                ->get();
        }
        
        $users = User::where('status',1)
        ->select(DB::raw("CONCAT(fullname,' ',last_name) AS name"),'id')
        ->pluck('name','id')->prepend('Seleccionar Todo…', '');

        $data = [
            'data' =>[
                'user_id' => $req->user_id,
                'since' => $req->since,
                'until' => $req->until
                ]
        ];
        $user_id = $req->user_id;
        $since = $req->since;
        $until = $req->until;
        //$data = json_encode($data, JSON_NUMERIC_CHECK);
        //dd($data);
        return view('pages.report.index',compact('asistencia','users','user_id','since','until'));
    }

    public function report_jornada_filter(Request $req){

        ini_set('max_execution_time', 300);
        set_time_limit(0);
        $asistencia = DB::table('jornada')->get();

        $grupos = DB::table('groups_users')->where('id_user', Auth::user()->id)->pluck('id_group');
        $users = User::where('status',1)
        ->select(DB::raw("CONCAT(fullname,' ',last_name) AS name"),'id')
        ->pluck('name','id')->prepend('Seleccionar Todo…', '');

        if($req->user_id != '' || $req->user_id != null){
            $asistencia = DB::table('jornada')
                        ->leftjoin('users as us','jornada.usuario','us.id')
                        ->leftjoin('users_groups as ug','us.id','ug.id_user')
                        ->leftjoin('groups as gr','ug.id_group','gr.id')
                        ->select('jornada.*')
                        ->where('usuario',$req->user_id)
                        ->whereBetween('since',[$req->since,$req->until])
                        ->whereIn('gr.id',$grupos)
                        ->orderBy('jornada.fecha','DESC')
                        ->get();
        }else{
                $asistencia = DB::table('jornada')
                            ->leftjoin('users as us','jornada.usuario','us.id')
                            ->leftjoin('users_groups as ug','us.id','ug.id_user')
                            ->leftjoin('groups as gr','ug.id_group','gr.id')
                            ->select('jornada.*')
                            ->whereBetween('since',[$req->since,$req->until])
                            ->orWhereBetween('until',[$req->since,$req->until])
                            ->whereIn('gr.id',$grupos)
                            ->orderBy('jornada.fecha','DESC')
                            ->get();
            
        }
        
        
        $primer = DB::table('jornada')->first();
        $ultimo = DB::table('jornada')->orderBy('fecha', 'desc')->first();
        $inicio = strtotime($primer->fecha);
        $final = strtotime($ultimo->fecha."+ 1 days");

        $user_id = $req->user_id;
        $since = $req->since;
        $until = $req->until;

        return view('pages.report.jornada',compact('asistencia','inicio','final','users','user_id','since','until'));
    }

    public function exportReportPDF(Request $req,$user_id, $since, $until){
        
        if($user_id != 0 && $since != '01-01-2021'  && $until != '01-01-2021'){
            $asistencia = Asistencia::where('id_user',$user_id)
                                ->whereBetween('fecha',[$since,$until])
                                ->orderBy('fecha','DESC')
                                ->get();
        }else if($user_id == 0 && $since != '01-01-2021'  && $until != '01-01-2021'){
            $asistencia = Asistencia::whereBetween('fecha',[$since,$until])
                                ->orWhereBetween('fecha_salida',[$since,$until])
                                ->orderBy('fecha','DESC')
                                ->get();
        }else{
            $asistencia = Asistencia::orderBy('fecha','DESC')
            ->get();
        }
        

        $pdf = \PDF::loadView('pages.report.reporte_marcaje', compact('asistencia'));

        return $pdf->download('reporte.pdf');
    }

    public function exportReportExcel(Request $req,$user_id, $since, $until){
        
        if($user_id != 0 && $since != '01-01-2021'  && $until != '01-01-2021'){
            $asistencia = Asistencia::where('id_user',$user_id)
                                ->whereBetween('fecha',[$since,$until])
                                ->orderBy('fecha','DESC')
                                ->get();
        }else if($user_id == 0 && $since != '01-01-2021'  && $until != '01-01-2021'){
            $asistencia = Asistencia::whereBetween('fecha',[$since,$until])
                                ->orWhereBetween('fecha_salida',[$since,$until])
                                ->orderBy('fecha','DESC')
                                ->get();
        }else{
            $asistencia = Asistencia::orderBy('fecha','DESC')
            ->get();
        }
        

        return Excel::download(new MarcajeExport($asistencia), 'reporte_marcaje.xlsx');
    }

    public function exportJornadaReportPDF(Request $req,$user_id, $since, $until){

        $asistencia = DB::table('jornada')->get();

        $grupos = DB::table('groups_users')->where('id_user', Auth::user()->id)->pluck('id_group');
        
        if($user_id != 0 && $since != '01-01-2021'  && $until != '01-01-2021'){
            $asistencia = DB::table('jornada')
            ->leftjoin('users as us','jornada.usuario','us.id')
            ->leftjoin('users_groups as ug','us.id','ug.id_user')
            ->leftjoin('groups as gr','ug.id_group','gr.id')
            ->select('jornada.*')
            ->where('usuario',$req->user_id)
            ->whereBetween('since',[$req->since,$req->until])
            ->whereIn('gr.id',$grupos)
            ->orderBy('jornada.fecha','DESC')
            ->get();
        }else if($user_id == 0 && $since != '01-01-2021'  && $until != '01-01-2021'){
            $asistencia = DB::table('jornada')
                        ->leftjoin('users as us','jornada.usuario','us.id')
                        ->leftjoin('users_groups as ug','us.id','ug.id_user')
                        ->leftjoin('groups as gr','ug.id_group','gr.id')
                        ->select('jornada.*')
                        ->whereBetween('since',[$req->since,$req->until])
                        ->whereIn('gr.id',$grupos)
                        ->orderBy('jornada.fecha','DESC')
                        ->get();
        }else{
            $asistencia =   DB::table('jornada')->get();
        }
        
        $primer = DB::table('jornada')->first();
        $ultimo = DB::table('jornada')->orderBy('fecha', 'desc')->first();
        $inicio = strtotime($primer->fecha);
        $final = strtotime($ultimo->fecha."+ 1 days");


        $pdf = \PDF::loadView('pages.report.reporte_jornada', compact('asistencia','inicio','final'));

        return $pdf->download('reporte_jornada.pdf');
    }

    public function exportJornadaReportExcel(Request $req,$user_id, $since, $until){
        
        $asistencia = DB::table('jornada')->get();

        $grupos = DB::table('groups_users')->where('id_user', Auth::user()->id)->pluck('id_group');

        
        if($user_id != 0 && $since != '01-01-2021'  && $until != '01-01-2021'){
            $asistencia = DB::table('jornada')
            ->leftjoin('users as us','jornada.usuario','us.id')
            ->leftjoin('users_groups as ug','us.id','ug.id_user')
            ->leftjoin('groups as gr','ug.id_group','gr.id')
            ->select('jornada.*')
            ->where('usuario',$req->user_id)
            ->whereBetween('since',[$req->since,$req->until])
            ->whereIn('gr.id',$grupos)
            ->orderBy('jornada.fecha','DESC')
            ->get();
        }else if($user_id == 0 && $since != '01-01-2021'  && $until != '01-01-2021'){
            $asistencia = DB::table('jornada')
                        ->leftjoin('users as us','jornada.usuario','us.id')
                        ->leftjoin('users_groups as ug','us.id','ug.id_user')
                        ->leftjoin('groups as gr','ug.id_group','gr.id')
                        ->select('jornada.*')
                        ->whereBetween('since',[$req->since,$req->until])
                        ->whereIn('gr.id',$grupos)
                        ->orderBy('jornada.fecha','DESC')
                        ->get();
        }else{
            $asistencia =   DB::table('jornada')->get();
        }
        
        return Excel::download(new JornadaExport($asistencia), 'reporte_jornada.xlsx');
    }
}
