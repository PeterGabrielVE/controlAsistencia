<!-- Modal -->
{!! Form::open(['method'=>'PUT','class'=>'formlDinamic form','id'=>'DataUpdate']) !!}
<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"><i class="icon icon-documents3 text-blue s-18"></i>Editar Empresa</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-row"> 
							<div class="form-group col-3 m-0" id="description_group">
								{!! Form::label('lbl_name', 'Nombre', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('name', null, ['class'=>'form-control r-0 light s-12','id'=>'_name','required']) !!}
							</div>
							<div class="form-group col-2 m-0" id="ingreso_group">
								{!! Form::label('lbl', 'RUT', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('rut', null, ['class'=>'form-control r-0 light s-12','id'=>'_rut']) !!}
							</div>
                            <div class="form-group col-3 m-0" id="ingreso_max_group">
								{!! Form::label('lbl_telefono', 'Telefono', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('phone', null, ['class'=>'form-control r-0 light s-12','id'=>'_phone']) !!}
							</div>
							<div class="form-group col-4 m-0" id="colacion_group">
								{!! Form::label('lbl_email', 'Correo', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('mail', null, ['class'=>'form-control r-0 light s-12','id'=>'_mail']) !!}
							</div>
						</div>
						<div class="form-row">
                        	<div class="form-group col-2 m-0" id="salida_group">
								{!! Form::label('lbl_flat', 'Piso', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('flat', null, ['class'=>'form-control r-0 light s-12','id'=>'_flat']) !!}
							</div>
							<div class="form-group col-4 m-0" id="colacion_group">
								{!! Form::label('lbl_city', 'Ciudad', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('town', null, ['class'=>'form-control r-0 light s-12','id'=>'_town']) !!}
							</div>
                            <div class="form-group col-3 m-0" id="ingreso_max_group">
								{!! Form::label('lbl_region', 'Región', ['class'=>'col-form-label s-12']) !!}
								{!! Form::select('id_region',$regions, null, ['class'=>'form-control r-0 light s-12','id'=>'_id_region']) !!}
							</div>
                            <div class="form-group col-3 m-0" id="tipo_colacion_group">
								{!! Form::label('lbl_commune', 'Comuna', ['class'=>'col-form-label s-12']) !!}
								{!! Form::select('id_commune',$communes, null, ['class'=>'form-control r-0 light s-12','id'=>'_id_commune']) !!}
							</div>
                            
                            <div class="form-group col-12 m-0" id="tipo_turno_group">
								{!! Form::label('lbl_address', 'Dirección', ['class'=>'col-form-label s-12']) !!}
								{!! Form::textarea('direction',null, ['class'=>'form-control r-0 light s-12','id'=>'_direction','rows'=>'1']) !!}
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
