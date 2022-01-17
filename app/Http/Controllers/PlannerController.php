<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Assignment;
use App\Models\Planner;
use App\Models\Type_Planner;
use App\Models\Turn;
use App\User;
use DB;
class PlannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $planners = Planner::all();
        return view('pages.planner.index',compact('planners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        switch ($id) {
            case 'semanal':
                $type = 1;
                break;
            case 'mensual':
                $type = 2;
                break;
            case 'personalizado':
                $type = 3;
                break;
            default:
                $type = 1;
                break;
        }
        $turns = Turn::get()->pluck('detalles','id')->prepend('Seleccione...','');
        $types = Type_Planner::where('id',1)->pluck('nombre','id')->prepend('Seleccione...','');
        return view('pages.planner.create',compact('turns','types','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $planificacion = array();
        $planificacion = [
            'turno_dia1' => $request->turno_dia1,
            'turno_dia2' => $request->turno_dia2,
            'turno_dia3' => $request->turno_dia3,
            'turno_dia4' => $request->turno_dia4,
            'turno_dia5' => $request->turno_dia5,
            'turno_dia6' => $request->turno_dia6,
            'turno_dia7' => $request->turno_dia7
        ];

        $plann = implode(',',$planificacion);
        $planner = new Planner();
        $planner->descripcion = $request->descripcion;
        $planner->tipo_planificador = $request->tipo_planificador;
        $planner->Estado = $request->Estado;
        $planner->planificacion = $plann;
        $planner->save();
        toastr()->success('¡Se ha registrado exitosamente!');
        return redirect()->route('planificador.index');
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
        $planner = Planner::find($id);
        $turns = Turn::get()->pluck('detalles','id')->prepend('Seleccione...','');
        $types = Type_Planner::get()->pluck('nombre','id')->prepend('Seleccione...','');
        return view('pages.planner.edit',compact('planner','turns','types'));
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
        $planificacion = array();
        $planificacion = [
            'turno_dia1' => $request->turno_dia1,
            'turno_dia2' => $request->turno_dia2,
            'turno_dia3' => $request->turno_dia3,
            'turno_dia4' => $request->turno_dia4,
            'turno_dia5' => $request->turno_dia5,
            'turno_dia6' => $request->turno_dia6,
            'turno_dia7' => $request->turno_dia7
        ];

        $plann = implode(',',$planificacion);
        $planner = Planner::find($id);
        $planner->descripcion = $request->descripcion;
        $planner->tipo_planificador = $request->tipo_planificador;
        $planner->Estado = $request->Estado;
        $planner->planificacion = $plann;
        $planner->save();
        toastr()->success('¡Se ha actualizado exitosamente!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $planner = Planner::find($id);
        $planner->delete();
        toastr()->success('¡Se ha eliminado exitosamente!');
        return response()->json(['message'=>'Planificador eliminado correctamente']);
    }

    public function assignment()
    {
        $planners = Planner::get()->pluck('descripcion','id')->prepend('Seleccione...','');
        $users = User::select(
            DB::raw("CONCAT(fullname,' ',last_name) AS name"),'id')
            ->orderBy('name')
            ->pluck('name', 'id')->prepend('Seleccione...','');
        $assignments = Assignment::all();
        $turns = Turn::get()->pluck('detalles','id')->prepend('Seleccione...','');
        return view('pages.planner.assignment',compact('planners','users','turns','assignments'));
    }

    public function assignmentStore(Request $request)
    {
            $assig = Assignment::where('user_id',$request->user_id)
            ->whereRaw('? between since and until', [$request->since])
            ->get();

            if($assig->count() > 0){
                toastr()->error('¡Ya existe una planificación asignada con esa fecha!');
                return back()->withInput();
            }

            $assig2 = Assignment::where('user_id',$request->user_id)
            ->whereRaw('? between since and until', [$request->until])
            ->get();

            if($assig2->count() > 0){
                toastr()->error('¡Ya existe una planificación asignada con esa fecha!');
                return back()->withInput();
            }

            $assig3 = Assignment::where('user_id',$request->user_id)
            ->WhereBetween('since', [$request->since,$request->until])
            ->get();

            if($assig3->count() > 0){
                toastr()->error('¡Ya existe una planificación asignada con esa fecha!');
                return back()->withInput();
            }

            $assig4 = Assignment::where('user_id',$request->user_id)
            ->WhereBetween('until', [$request->since,$request->until])
            ->get();

            if($assig4->count() > 0){
                toastr()->error('¡Ya existe una planificación asignada con esa fecha!');
                return back()->withInput();
            }

            $data = $request->all();
            $planner = Planner::find($request->planner_id);
            $turnos = explode(",", $planner->planificacion);
            DB::statement('CALL guardarfechas(?,?,?,?,?,?,?,?,?,?,?)', array($request->user_id, $request->planner_id,
            $request->since, $request->until, $turnos[0],$turnos[1],$turnos[2], $turnos[3], $turnos[4], $turnos[5], $turnos[6] ));
            Assignment::create($data);
            toastr()->success('¡Registro existoso!');
            return redirect()->back();
    }

    public function assignmentEdit($id)
    {
        $assig = Assignment::find($id);
        return response()->json($assig);
    }

    public function assignmentUpdate(Request $request)
    {
        $assig1 = Assignment::where('user_id',$request->user_id)
        ->where('id','!=',$request->id_assignment)
        ->whereRaw('? between since and until', [$request->since])
        ->get();

        if($assig1->count() > 0){
            toastr()->error('¡Ya existe una planificación asignada con esa fecha!');
            return back()->withInput();
        }

        $assig2 = Assignment::where('user_id',$request->user_id)
        ->where('id','!=',$request->id_assignment)
        ->whereRaw('? between since and until', [$request->until])
        ->get();

        if($assig2->count() > 0){
            toastr()->error('¡Ya existe una planificación asignada con esa fecha!');
            return back()->withInput();
        }

        $assig3 = Assignment::where('user_id',$request->user_id)
        ->where('id','!=',$request->id_assignment)
        ->WhereBetween('since', [$request->since,$request->until])
        ->get();

        if($assig3->count() > 0){
            toastr()->error('¡Ya existe una planificación asignada con esa fecha!');
            return back()->withInput();
        }

        $assig4 = Assignment::where('user_id',$request->user_id)
        ->where('id','!=',$request->id_assignment)
        ->WhereBetween('until', [$request->since,$request->until])
        ->get();

        if($assig4->count() > 0){
            toastr()->error('¡Ya existe una planificación asignada con esa fecha!');
            return back()->withInput();
        }


        $data = $request->all();
        $assig = assignment::find($request->id_assignment);
        $assig->update($data);

        $calendar = DB::table('calendar')->where('usuario',$request->user_id)->where('plan',$request->planner_id)->delete();
        $planner = Planner::find($request->planner_id);
        $turnos = explode(",", $planner->planificacion);
        DB::statement('CALL guardarfechas(?,?,?,?,?,?,?,?,?,?,?)', array($request->user_id, $request->planner_id,
            $request->since, $request->until, $turnos[0],$turnos[1],$turnos[2], $turnos[3], $turnos[4], $turnos[5], $turnos[6] ));

        toastr()->success('¡Se ha actualizado exitosamente!');
        return redirect()->back();
    }

    public function assignmentDestroy($id)
    {
        $planner = Assignment::find($id);
        $calendar = DB::table('calendar')->where('usuario',$planner->user_id)->where('plan',$planner->planner_id)->delete();
        $planner->delete();
        toastr()->success('¡Planificador eliminado correctamente!');

        return response()->json(['message'=>'Planificador eliminado correctamente']);
    }

    public function check_date(Request $request)
    {
        $assig = Assignment::where('user_id',$request->user_id)
        ->whereRaw('? between since and until', [$request->date])
        ->get();

        if($assig->count() == 0){
            return response()->json('true');
        }else{
            return response()->json('false');
        }
    }

}
