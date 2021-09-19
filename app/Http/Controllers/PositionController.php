<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Position;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions=Position::all();
        return view('pages.position.index',compact('positions')); 
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
        Position::create($data);
        toastr()->success('¡Se ha registrado exitosamente!');
        return response()->json(['message'=>'Posición registrado correctamente']);

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
        $position = Position::find($id);
        return response()->json($position);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position = Position::find($id);
        return response()->json($position);
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
        $position = Position::find($id);
        $position->update($request->all());
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
        try{
        $position = Position::find($id);
        $position->delete();
        toastr()->success('¡Se ha eliminado exitosamente!');
        return response()->json(['message'=>'Posición eliminado correctamente']);

    }catch (\Exception $e){
        toastr()->success('¡Ocurrió un problema!');
        return redirect()->back();
     }
    }
}
