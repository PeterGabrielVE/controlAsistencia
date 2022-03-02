<!-- Modal -->
{!! Form::open(['method'=>'PUT','class'=>'formlDinamic form','id'=>'DataUpdate']) !!}
<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"><i class="icon icon-documents3 text-blue s-18"></i>Editar Turno</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-row">
							<div class="form-group col-4 m-0">
								{!! Form::label('lbl_name', 'Nombre', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('name', null, ['class'=>'form-control r-0 light s-12','id'=>'_name','required']) !!}
								<span class="description_span"></span>
							</div>
							<div class="form-group col-4 m-0">
								{!! Form::label('lbl_rut', 'RUT', ['class'=>'col-form-label s-12']) !!}
								{!! Form::time('rut', null, ['class'=>'form-control r-0 light s-12','id'=>'_rut']) !!}
								<span class="ingreso_span"></span>
							</div>
                            <div class="form-group col-4 m-0"
								{!! Form::label('lb_email', 'Correo', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('email', null, ['class'=>'form-control r-0 light s-12','id'=>'_email']) !!}
							</div>
                            <div class="form-group col-4 m-0" id="colacion_group">
								{!! Form::label('lbl_phone', 'Teléfono', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('phone', null, ['class'=>'form-control r-0 light s-12','id'=>'_phone']) !!}
								<span class="colacion_span"></span>
							</div>
                        <div class="form-group col-4 m-0" id="salida_group">
								{!! Form::label('lbl_flat', 'Piso', ['class'=>'col-form-label s-12']) !!}
								{!! Form::time('flat', null, ['class'=>'form-control r-0 light s-12','id'=>'_flat']) !!}
								<span class="salida_span"></span>
							</div>
                            <div class="form-group col-4 m-0" id="ingreso_max_group">
								{!! Form::label('horas_trabajo', 'Horas Trabajo', ['class'=>'col-form-label s-12']) !!}
								{!! Form::number('horas_trabajo', null, ['class'=>'form-control r-0 light s-12','id'=>'_horas_trabajo']) !!}
								<span class="ingreso_span"></span>
							</div>
                            <div class="form-group col-4 m-0" id="tiempo_colacion_group">
								{!! Form::label('tiempo_colacion', 'Tiempo Colación', ['class'=>'col-form-label s-12']) !!}
								{!! Form::number('tiempo_colacion', null, ['class'=>'form-control r-0 light s-12','id'=>'_tiempo_colacion']) !!}
								<span class="tiempo_colacion_span"></span>
							</div>
                            <div class="form-group col-4 m-0" id="tipo_colacion_group">
								{!! Form::label('tiempo_colacion', 'Tipo De Colación', ['class'=>'col-form-label s-12']) !!}
							
								<span class="tipo_colacion_span"></span>
							</div>
                            <div class="form-group col-4 m-0" id="tipo_turno_group">
								{!! Form::label('tiempo_colacion', 'Tipo', ['class'=>'col-form-label s-12']) !!}
								
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
