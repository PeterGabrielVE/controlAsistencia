@extends('layouts.app')
@section('title')
<h1 class="nav-title text-white"> Configuración > <i class="icon icon-documents3 text-blue s-18"></i>PLANIFICADORES</h1>
@endsection
@section('maincontent')

<div class="page height-full">

    {{-- alerts --}}
    <div class="container-fluid animatedParent animateOnce my-3">
        <div class="animated fadeInUpShort">
            <div class="card">
                <div class="form-group">
                    <div class="card-header white">
                        <h6> ACTUALIZAR PLANIFICADOR </h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('planificador.update',$planner->id) }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="form-row">
                            <div class="form-group col-4 m-0">
								{!! Form::label('descripcion', 'Nombre', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('descripcion', $planner->descripcion ?? null, ['class'=>'form-control r-0 light s-12','id'=>'descripcion','required']) !!}
								<span class="descripcion_span"></span>
							</div>
                            <div class="form-group col-4 m-0">
								{!! Form::label('horas_trabajo', 'Tipo Planificador', ['class'=>'col-form-label s-12']) !!}
								{!! Form::select('tipo_planificador',$types, $planner->tipo_planificador ?? null, ['class'=>'form-control r-0 light s-12','id'=>'tipo_planificador','required']) !!}
								<span class="ingreso_span"></span>
							</div>
                            <div class="form-group col-4 m-0">
								{!! Form::label('estado', 'Estado', ['class'=>'col-form-label s-12']) !!}
								{!! Form::select('Estado',[''=>'Seleccione...','0'=>'Activo','1'=>'Inactivo'], $planner->Estado ?? null, ['class'=>'form-control r-0 light s-12','id'=>'estado','required']) !!}
								<span class="estado_span"></span>
							</div>
                    </div>
                    <div class="form-row">
                        <?php $planificacion = explode(',',$planner->planificacion); ?>
                            <div class="form-inline col-12 mt-4">
								{!! Form::label('dia_1', 'Día 1', ['class'=>'col-form-label s-12 col-1']) !!}
								{!! Form::select('turno_dia1',$turns, $planificacion[0] ?? null, ['class'=>'form-control r-0 light s-12 col-11','id'=>'turno_dia1','required']) !!}
								<span class="dia1_span"></span>
							</div>
                            <div class="form-inline col-12 mt-4">
								{!! Form::label('dia_2', 'Día 2', ['class'=>'col-form-label s-12 col-1']) !!}
								{!! Form::select('turno_dia2',$turns, $planificacion[1] ?? null, ['class'=>'form-control r-0 light s-12 col-11','id'=>'turno_dia2','required']) !!}
								<span class="dia2_span"></span>
							</div>
                            <div class="form-inline col-12 mt-4">
								{!! Form::label('dia_3', 'Día 3', ['class'=>'col-form-label s-12 col-1']) !!}
								{!! Form::select('turno_dia3',$turns, $planificacion[2] ?? null, ['class'=>'form-control r-0 light s-12 col-11','id'=>'turno_dia3','required']) !!}
								<span class="dia3_span"></span>
							</div>
                            <div class="form-inline col-12 mt-4">
								{!! Form::label('dia_4', 'Día 4', ['class'=>'col-form-label s-12 col-1']) !!}
								{!! Form::select('turno_dia4',$turns, $planificacion[3] ?? null, ['class'=>'form-control r-0 light s-12 col-11','id'=>'turno_dia4','required']) !!}
								<span class="dia4_span"></span>
							</div>
                            <div class="form-inline col-12 mt-4">
								{!! Form::label('dia_5', 'Día 5', ['class'=>'col-form-label s-12 col-1']) !!}
								{!! Form::select('turno_dia5',$turns, $planificacion[4] ?? null, ['class'=>'form-control r-0 light s-12 col-11','id'=>'turno_dia5','required']) !!}
								<span class="dia5_span"></span>
							</div>
                            <div class="form-inline col-12 mt-4">
								{!! Form::label('6', 'Día 6', ['class'=>'col-form-label s-12 col-1']) !!}
								{!! Form::select('turno_dia6',$turns, $planificacion[5] ?? null, ['class'=>'form-control r-0 light s-12 col-11','id'=>'turno_dia6','required']) !!}
								<span class="dia1_span"></span>
							</div>
                            <div class="form-inline col-12 mt-4">
								{!! Form::label('dia_7', 'Día 7', ['class'=>'col-form-label s-12 col-1']) !!}
								{!! Form::select('turno_dia7',$turns, $planificacion[6] ?? null, ['class'=>'form-control r-0 light s-12 col-11','id'=>'turno_dia7','required']) !!}
								<span class="dia1_span"></span>
							</div>
                        </div>
                        <div class="row text-right">
                            <div class="col-md-12 mt-4">
                                    <a href="{{ url()->previous() }}" class="btn btn-default">{{__('Atrás')}}</a>
                                    <button  type="submit" id="editar" class="btn btn-primary"><i class="icon-save mr-2"></i>{{__('Guardar Datos')}}</button>
                            </div>
                        </div>
                </div>
                </form>
            </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
