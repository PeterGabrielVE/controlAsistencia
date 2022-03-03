<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Region;
use App\Commune;
use Session;
use Redirect;

class BusinessController extends Controller
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
        $business = Business::all();
        $regions = Region::get()->sortBy('name')->pluck('name','id')->prepend('Seleccione...','');
        $communes = Commune::get()->sortBy('name')->pluck('name','id')->prepend('Seleccione...','');
        return view('pages.business.index',compact('business','regions','communes'));
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
        $rol = Business::create($data);
        return response()->json(['message'=>'Rol registrado correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return response()->json();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edif = Business::find($id);
        return response()->json($edif);
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
        $edif = Business::find($id);
        $edif->update($request->all());
        $edif->save();
        toastr()->success('¡Se ha actualizado exitosamente!');
        Session::flash('message-success',' Edificio '. $request->name .' editada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $edif = Business::find($id);
        $edif->delete();
        toastr()->success('¡Se ha eliminado exitosamente!');
        return response()->json(['message'=>'Se ha eliminado correctamente']);
    }

    public function searchCommunes(Request $req)
    {
        $communes = Commune::where('region_id',$req->region_id)->get()->sortBy('name')->pluck('name','id')->prepend('Seleccione...','');
        return response()->json($communes);
    }

    public function searchRegion(Request $req)
    {
        $communes = Commune::where('id',$req->commune_id)->value('region_id');
        return response()->json($communes);
    }
}
