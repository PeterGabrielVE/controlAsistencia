<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Turn;
use App\Models\Type_Turn;
use App\Models\Type_Collation;
use App\Models\Planner;

class TurnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $turns=Turn::all();
        $tipos = Type_Turn::get()->pluck('name','id')->prepend('Seleccione un tipo','');
        $collations = Type_Collation::get()->pluck('name','id')->prepend('Seleccione un tipo','');
        return view('pages.turn.index',compact('turns','tipos','collations'));
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
        try{
        $data = $request->all();
        Turn::create($data);
        toastr()->success('¡Se ha registrado exitosamente!');
        return response()->json(['message'=>'Turno registrado correctamente']);

        }catch (\Exception $e){
        toastr()->success('¡Ocurrió un problema!');
        return redirect()->back();
        }
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
        $turn = Turn::find($id);
        return response()->json($turn);
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
        try{
        $turn = Turn::find($id);
        $turn->update($request->all());
        toastr()->success('¡Se ha actualizado exitosamente!');
        Session::flash('message-success',' Posición actualizado correctamente.');

    }catch (\Exception $e){
        toastr()->success('¡Ocurrió un problema!');
        return redirect()->back();
     }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existe = false;
        $plann = Planner::where('planificacion','like','%'.$id.',')->orWhere('planificacion','like','%'.','.$id.'%')->get();
    
        try{
        if(count($plann) > 0){
            toastr()->error('¡No se puede eliminar! Existen planificaciones con esta turno.');
            return response()->json(['message'=>'¡No se puede eliminar! Existen planificaciones con esta turno.']);
        }
        $turn =Turn::find($id);
        $turn->delete();
        toastr()->success('¡Se ha eliminado exitosamente!');
        return response()->json(['message'=>'Posición eliminado correctamente']);

    }catch (\Exception $e){
        toastr()->success('¡Ocurrió un problema!');
        return redirect()->back();
     }
    }
}
