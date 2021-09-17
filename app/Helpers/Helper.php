<?php

    use App\Models\Turn;
    use App\Asistencia;
    use App\Models\Type_Turn;

    function check_in_range($fecha_inicio, $fecha_fin, $fecha){

        $fecha_inicio = strtotime($fecha_inicio);
        $fecha_fin = strtotime($fecha_fin);
        $fecha = $fecha;

        if(($fecha >= $fecha_inicio) && ($fecha <= $fecha_fin)) {

            return true;

        } else {

            return false;

        }
    }

    function check_turn($fecha,$planificacion){

        //$day = date('l', $fecha);
        $day = (date('N', $fecha)) - 1;
        $array = explode ( ',', $planificacion);
        $longitud = count($array) - 1;


        for($i=0; $i <= $longitud; $i++)
        {
            if($i  == $day){
                $turn = Turn::find($array[$i]);
                return $turn->detalles;
            }

        }

    }

    function obtener_atraso($fecha,$planificacion,$hour){

        //$day = date('l', $fecha);
        $day = (date('N', $fecha)) - 1;
        $array = explode ( ',', $planificacion);
        $longitud = count($array) - 1;

        for($i=0; $i <= $longitud; $i++)
        {
            if($i  == $day){
                $turn = Turn::find($array[$i]);
                $ingreso = $turn->ingreso;

                $horaInicio = $ingreso.':00';
                $horafin = Carbon\Carbon::parse($hour)->format('H:i:s');

                $horai=substr($horaInicio,0,2);
                $mini=substr($horaInicio,3,2);
                $segi=substr($horaInicio,6,2);

                $horaf=substr($horafin,0,2);
                $minf=substr($horafin,3,2);
                $segf=substr($horafin,6,2);

                $ini=((($horai*60)*60)+($mini*60)+$segi);
                $fin=((($horaf*60)*60)+($minf*60)+$segf);

                $dif=$fin-$ini;

                $difh=floor($dif/3600);
                $difm=floor(($dif-($difh*3600))/60);
                $difs=$dif-($difm*60)-($difh*3600);
                return $difh.' Horas '.$difm.' minutos';

            }

        }

    }

    function check_day($fecha,$user){

        $fecha =  Carbon\Carbon::parse($fecha)->format('Y-m-d');
        $asistencia = Asistencia::where('id_user',$user)->whereDate('fecha',$fecha)->get();

        if(count($asistencia) > 0) {
            return true;
        } else {
            return false;
        }
    }
