<!-- Modal -->
{!! Form::open(['route'=>'incident.store','method'=>'POST', 'class'=>'formlDinamic', 'id'=>'guardarRegistro']) !!}
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"><i class="icon icon-documents3 text-blue s-18"></i> Agregar Modulo</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-row">
							<div class="form-group col-4 m-0">
								{!! Form::label('modulo', 'Modulo', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('modulo', null, ['class'=>'form-control r-0 light s-12',  'id'=>'modulo', 'onclick'=>'inputClear(this.id)']) !!}
							</div>
							<div class="form-group col-8 m-0">
								{!! Form::label('modulo', 'Modulo', ['class'=>'col-form-label s-12']) !!}
								{!! Form::textarea('modulo', null, ['class'=>'form-control r-0 light s-12',  'id'=>'modulo', 'onclick'=>'inputClear(this.id)']) !!}
							</div>
							
						</div>
						<div class="form-row">
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