<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime;
use App\Asistencia;
use App\User;
use App\Mail\SendMail;
use Mail;

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
        $ip = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        try{
            $img = $request->image;
            $fileName = '';
            if($img != null || !empty($img)){
                $path = public_path().'/img/avatar/';

                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_parts[0] = isset($image_type_aux[1]) ? $image_type_aux[1] : null;

                $image_base64 = base64_decode($image_parts[1]);
                $fileName = uniqid() . '.png';

                $file = $path . $fileName;
                file_put_contents($file, $image_base64);
            }
        

            if($request->tipo == 0){
                $asis = new Asistencia();
                $asis->id_user = Auth::user()->id;
                $asis->fecha = Carbon::now();
                $asis->tipo = $request->tipo;
                $asis->sistema = 'web';
                $asis->ip = $request->ip() ?? $ip;
                $asis->image = $fileName;
                $asis->latitude = $request->latitude;
                $asis->longitude = $request->longitude;
                $asis->save();
                $this->sendEmail($asis,'Entrada');
                toastr()->success('??Se ha registrado exitosamente!');

                return redirect()->back();
            }else{
                $asis = Asistencia::where('id_user',Auth::user()->id)->orderBy('fecha', 'desc')->first();

                $marca = Asistencia::find($asis->id);
                $marca->fecha_salida = Carbon::now();
                $marca->tipo = 1;
                $marca->note= $request->note;
                $marca->ip_salida = $request->ip() ?? $ip;
                $marca->image_salida = $fileName;
                $marca->latitude_salida = $request->latitude;
                $marca->longitude_salida = $request->longitude;

                $marca->save();
                $this->sendEmail($asis,'Salida');
                toastr()->success('??Se ha registrado exitosamente!');
                return redirect()->back();
            }

        }catch (\Exception $e){
            toastr()->error('??Ocurri?? un problema!');
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
        $asistencia= Asistencia::find($id);
        return view('pages.asistencia.edit',compact('asistencia'));
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
        $asis = Asistencia::find($id);
        $asis->note = $request->note;

        $date = DateTime::createFromFormat('d-m-Y H:i:s', $request->fecha);
        $date = $date->format('Y-m-d H:i:s');

        $date_exit = DateTime::createFromFormat('d-m-Y H:i:s', $request->fecha_salida);
        $date_exit = $date_exit->format('Y-m-d H:i:s');

        $asis->fecha = $date;
        $asis->fecha_salida = $date_exit;
        $asis->save();
        toastr()->success('??Se ha actualizado exitosamente!');
        return redirect()->back();

        }catch (\Exception $e){
           toastr()->success('??Ocurri?? un problema!');
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
        $asis = Asistencia::find($id);
        $asis->delete();

        }catch (\Exception $e){
        toastr()->success('??Ocurri?? un problema!');
        return redirect()->back();
        }
    }

    public function sendEmail($asis,$tipo)
    {
        $user = User::find($asis->id_user);
        //dd($user);
        $fecha = Carbon::now();
        $ip = '';
        if($asis->tipo == 1){
            $fecha = $asis->fecha;
            $ip = $asis->ip;
        }else{
            $fecha = $asis->fecha_salida;
            $ip = $asis->ip_salida;
        }

        $user_detail = [
        'nombre' => $user->fullname.' '.$user->last_name,
        'fecha' => $fecha,
        'ip' => $ip,
        'tipo' => $tipo,
        'sistema' => $asis->sistema
        ];
        Mail::to($user->email)->send(new SendMail($user_detail));
          if (Mail::failures()) {
            return response()->Fail('Sorry! Please try again latter');
          }else{
            return response()->json('Yes, You have sent email to GMAIL from LARAVEL !!');
          }
    }
}
