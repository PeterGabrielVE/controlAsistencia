<?php

    use App\Models\Turn;
    use App\Asistencia;
    use App\Models\Type_Turn;
    use App\Models\Assignment;

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

    function check_turn($fecha,$turn){

        //$day = date('l', $fecha);
        /*$day = (date('N', $fecha)) - 1;

            if($turn  == $day){*/
                $turn = Turn::find($turn);
                if($turn){
                    return $turn->detalles;
                }else{
                    return '';
                }

            //}

    }

    function obtener_atraso($fecha,$turn,$hour){

        //$day = date('l', $fecha);
        $day = (date('N', $fecha)) - 1;


                $turn = Turn::find($turn);
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

                $dif=$ini-$fin;

                $difh=floor($dif/3600);
                $difm=floor(($dif-($difh*3600))/60);
                $difs=$dif-($difm*60)-($difh*3600);
                return $difh.' Horas '.$difm.' minutos';


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

    function obtener_plan($id,$user,$column){

        return Assignment::where('planner_id',$id)->where('user_id',$user)->value($column);
    }

    function obtener_salida($id){

        $asis = Asistencia::find($id);
        if($asis){
            if(!is_null($asis->fecha_salida)){
            return Carbon\Carbon::parse($asis->fecha_salida)->format('g:i:s A');
            }
        }

    }

