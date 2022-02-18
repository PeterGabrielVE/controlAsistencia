<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use Session;
use Redirect;

class IncidentController extends Controller
{
    private $permissions;

    public function __construct()
    {
        $this->permissions = Permission::get()->pluck('name','id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = $this->permissions;
        $roles = Role::all();
        return view('pages.rol.index',compact('roles','permissions'));
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
        $rol = Role::create($data);
        $rol->syncPermissions($data['permits']);
        return response()->json(['message'=>'Rol registrado correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $rol)
    {
        return response()->json($rol);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $rol)
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

        $rol = Role::find($id);
        $rol->update($request->all());
        $rol->syncPermissions($request->all('permits'));
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
    public function destroy(Role $rol)
    {
        $rol->delete();
        return response()->json(['message'=>'Rol eliminado correctamente']);
    }
}
