<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Asistencia;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //dd($request->all());

        $img = $request->image;
        $path = public_path().'/img/avatar/';

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_parts[0] = isset($image_type_aux[1]) ? $image_type_aux[1] : null;
        //$image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';

        $file = $path . $fileName;
        file_put_contents($file, $image_base64);


        $asis = new Asistencia();
        $asis->id_user = Auth::user()->id;
        $asis->fecha = Carbon::now();
        $asis->tipo = $request->tipo;
        $asis->sistema = 'web';
        $asis->ip = $request->ip();
        $asis->image = $fileName;
        $asis->latitude = $request->latitude;
        $asis->longitude = $request->longitude;
        $asis->save();
        toastr()->success('¡Se ha registrado exitosamente!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asistencia= Asistencia::find($id);
        return view('pages.report.show',compact('asistencia'));
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
        //dd($request->all());
        $asis = Asistencia::find($id);
        $asis->fecha = Carbon::now();
        $asis->tipo = $request->tipo;
        $asis->sistema = 'web';
        $asis->save();
        toastr()->success('¡Se ha actualizado exitosamente!');
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
}
