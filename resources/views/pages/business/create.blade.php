<!-- Modal -->
{!! Form::open(['route'=>'business.store','method'=>'POST', 'class'=>'formlDinamic', 'id'=>'guardarRegistro']) !!}
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"><i class="icon icon-documents3 text-blue s-18"></i> Agregar Empresa</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-row"> 
							<div class="form-group col-3 m-0" id="description_group">
								{!! Form::label('lbl_name', 'Nombre', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('name', null, ['class'=>'form-control r-0 light s-12','id'=>'name','required']) !!}
							</div>
							<div class="form-group col-2 m-0" id="ingreso_group">
								{!! Form::label('lbl', 'RUT', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('rut', null, ['class'=>'form-control r-0 light s-12','id'=>'rut']) !!}
							</div>
                            <div class="form-group col-3 m-0" id="ingreso_max_group">
								{!! Form::label('lbl_telefono', 'Telefono', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('phone', null, ['class'=>'form-control r-0 light s-12','id'=>'phone']) !!}
							</div>
							<div class="form-group col-4 m-0" id="colacion_group">
								{!! Form::label('lbl_email', 'Correo', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('mail', null, ['class'=>'form-control r-0 light s-12','id'=>'mail']) !!}
							</div>
						</div>
						<div class="form-row">
                        	<div class="form-group col-2 m-0" id="salida_group">
								{!! Form::label('lbl_flat', 'Piso', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('flat', null, ['class'=>'form-control r-0 light s-12','id'=>'flat']) !!}
							</div>
							<div class="form-group col-4 m-0" id="colacion_group">
								{!! Form::label('lbl_city', 'Ciudad', ['class'=>'col-form-label s-12']) !!}
								{!! Form::text('town', null, ['class'=>'form-control r-0 light s-12','id'=>'town']) !!}
							</div>
                            <div class="form-group col-3 m-0" id="ingreso_max_group">
								{!! Form::label('lbl_region', 'Región', ['class'=>'col-form-label s-12']) !!}
								{!! Form::select('id_region',$regions, null, ['class'=>'form-control r-0 light s-12','id'=>'id_region']) !!}
							</div>
                            <div class="form-group col-3 m-0" id="tipo_colacion_group">
								{!! Form::label('lbl_commune', 'Comuna', ['class'=>'col-form-label s-12']) !!}
								{!! Form::select('id_commune',$communes, null, ['class'=>'form-control r-0 light s-12','id'=>'id_commune']) !!}
							</div>
                            
                            <div class="form-group col-12 m-0" id="tipo_turno_group">
								{!! Form::label('lbl_address', 'Dirección', ['class'=>'col-form-label s-12']) !!}
								{!! Form::textarea('direction',null, ['class'=>'form-control r-0 light s-12','id'=>'direction','rows'=>'1']) !!}
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
<script>
	$( document ).ready(function() {
		$('#id_region').on("click", function(e) {
			let region = $(this).val();
			$.ajax({
				url:'searchCommunes',
				data:{'region_id':region},
				type:'get',
				success: function (response) {

					$("#id_commune").find('option').remove();
                     
						var options = [];
						$.each(response, function(key, value) {
						    options.push($("<option/>", {
						        value: key,
						        text: value
						    }));
						});

						var invertido = [];
							for (i=options.length-1; i>=0; i--) {
							  invertido.push( options[i] )
						}

						$("#id_commune").append(invertido);
						console.log(response);
				},
				statusCode: {
					404: function() {
						alert('web not found');
					}
				},
				error:function(x,xs,xt){
					//nos dara el error si es que hay alguno
					window.open(JSON.stringify(x));
					//alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
				}
			});
		})

		$('#id_commune').on("click", function(e) {
			let commune_id = $(this).val();
			$.ajax({
				url:'searchRegion',
				data:{'commune_id':commune_id},
				type:'get',
				success: function (response) {

					$("#id_region").val(response);
                	console.log(response);
				},
				statusCode: {
					404: function() {
						alert('web not found');
					}
				},
				error:function(x,xs,xt){
					//nos dara el error si es que hay alguno
					window.open(JSON.stringify(x));
					//alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
				}
			});
		})
	});
	
</script>
{!! Form::close() !!}
