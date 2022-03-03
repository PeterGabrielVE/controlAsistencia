<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidente;
use Session;
use Redirect;

class IncidentController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incidents = Incidente::all();
        return view('pages.incidents.index',compact('incidents'));
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
        $data = $request->all();
        $incident = Incidente::create($data);
        return response()->json(['message'=>'Rol registrado correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Incidente $rol)
    {
        return response()->json($rol);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Incidente $rol)
    {
        $rol = $rol;
        if ($rol->special == 'all-access') {
            $rol->special = 1;
        }else{
            $rol->special = 2;
        }
        $permissions = $this->permissions;
        return view('pages.rol.edit', compact('rol','permissions'));
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

        $rol = Incidente::find($id);
        $rol->update($request->all());
        $rol->save();
        Session::flash('message-success','El rol '. $request->name.' fue editado correctamente.');
        return Redirect::to('rol');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incidente $rol)
    {
        $rol->delete();
        return response()->json(['message'=>'Rol eliminado correctamente']);
    }
}
