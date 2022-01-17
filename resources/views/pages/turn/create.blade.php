<!-- Modal -->
{!! Form::open(['route'=>'turn.store','method'=>'POST', 'class'=>'formlDinamic', 'id'=>'guardarRegistro']) !!}
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"><i class="icon icon-documents3 text-blue s-18"></i> Agregar Turno</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-row">
							<div class="form-group col-4 m-0" id="description_group">
								{!! Form::label('description', 'Nombre', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('detalles', null, ['class'=>'form-control r-0 light s-12','id'=>'detalles','required']) !!}
								<span class="description_span"></span>
							</div>
							<div class="form-group col-4 m-0" id="ingreso_group">
								{!! Form::label('ingreso', 'Ingreso', ['class'=>'col-form-label s-12']) !!}
								{!! Form::time('ingreso', null, ['class'=>'form-control r-0 light s-12','id'=>'ingreso']) !!}
								<span class="ingreso_span"></span>
							</div>
                            <div class="form-group col-4 m-0" id="ingreso_max_group">
								{!! Form::label('ingreso', 'Ingreso Máximo', ['class'=>'col-form-label s-12']) !!}
								{!! Form::time('ingreso_max', null, ['class'=>'form-control r-0 light s-12','id'=>'ingreso_max']) !!}
								<span class="ingreso_span"></span>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-4 m-0" id="colacion_group">
								{!! Form::label('colacion', 'Colación', ['class'=>'col-form-label s-12']) !!}
								{!! Form::time('colacion', null, ['class'=>'form-control r-0 light s-12','id'=>'colacion']) !!}
								<span class="colacion_span"></span>
							</div>
                        	<div class="form-group col-4 m-0" id="salida_group">
								{!! Form::label('salida', 'Salida', ['class'=>'col-form-label s-12']) !!}
								{!! Form::time('salida', null, ['class'=>'form-control r-0 light s-12','id'=>'salida']) !!}
								<span class="salida_span"></span>
							</div>
                            <div class="form-group col-4 m-0" id="ingreso_max_group">
								{!! Form::label('horas_trabajo', 'Horas Trabajo', ['class'=>'col-form-label s-12']) !!}
								{!! Form::number('horas_trabajo', null, ['class'=>'form-control r-0 light s-12','id'=>'horas_trabajo']) !!}
								<span class="ingreso_span"></span>
							</div>
                            <div class="form-group col-3 m-0" id="tipo_colacion_group">
								{!! Form::label('tiempo_colacion', 'Tipo De Colación', ['class'=>'col-form-label s-12']) !!}
								{!! Form::select('tipo_colacion_id',$collations, null, ['class'=>'form-control r-0 light s-12','id'=>'tipo_colacion_id']) !!}
								<span class="tipo_colacion_span"></span>
							</div>
                            <div class="form-group col-3 m-0" id="tiempo_colacion_group">
								{!! Form::label('tiempo_colacion', 'Tiempo De Colación', ['class'=>'col-form-label s-12']) !!}
								{!! Form::number('tiempo_colacion', null, ['class'=>'form-control r-0 light s-12','id'=>'tiempo_colacion']) !!}
								<span class="tiempo_colacion_span"></span>
							</div>
                            <div class="form-group col-3 m-0" id="tipo_turno_group">
								{!! Form::label('tipo_turno', 'Tipo', ['class'=>'col-form-label s-12']) !!}
								{!! Form::select('tipo_turno',$tipos, null, ['class'=>'form-control r-0 light s-12','id'=>'tipo_turno']) !!}
								<span class="tipo_turno_span"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary"><i class="icon-save mr-2"></i>Guardar Datos</button>
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}
