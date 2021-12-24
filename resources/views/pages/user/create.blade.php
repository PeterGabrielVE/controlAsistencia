<!-- Modal -->
{!! Form::open(['route'=>'user.store','method'=>'POST', 'class'=>'formlDinamic', 'id'=>'guardarRegistroMultitap','enctype'=>'multipart/form-data','files'=>'true']) !!}
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"><i class="icon-person"></i> Agregar Nuevo Usuario</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-row">
							<div class="col-8">
								<div class="form-row">
									<div class="form-group m-0 col-6 has-feedback" id="fullname_group">
										<i class="icon-person mr-2"></i>
										{!! Form::label('name', '* Nombres', ['class'=>'col-form-label s-12']) !!}
										{!! Form::text('fullname', null, ['class'=>'form-control r-0 light s-12',  'id'=>'fullname', 'onclick'=>'inputClear(this.id)','required']) !!}
										<span class="fullname_span"></span>
									</div>
									<div class="form-group m-0 col-6 has-feedback" id="last_name_group">
										<i class="icon-person mr-2"></i>
										{!! Form::label('last_name', '* Apellidos', ['class'=>'col-form-label s-12']) !!}
										{!! Form::text('last_name', null, ['class'=>'form-control r-0 light s-12',  'id'=>'user_last_name','required']) !!}
										<span class="last_name_span"></span>
									</div>
									<div class="form-group col-6 m-0" id="password_group">
										<i class="icon-key3 mr-2"></i>
										{!! Form::label('password', '* Contraseña', ['class'=>'col-form-label s-12',  'onclick'=>'inputClear(this.id)']) !!}
										{!! Form::password('password', ['class'=>'form-control r-0 light s-12','id'=>'_password']) !!}
										<span class="password_span"></span>
									</div>
									<div class="form-group col-6 m-0">
										<i class="icon-key4 mr-2"></i>
										{!! Form::label('passwordConfirm', '* Confirmar Contraseña', ['class'=>'col-form-label s-12']) !!}
										{!! Form::password('password_confirmation', ['class'=>'form-control r-0 light s-12', 'id'=>'_password_confirmation']) !!}
									</div>
									<div class="form-group col-6 m-0" id="email_group">
										<i class="icon-envelope-o mr-2"></i>
										{!! Form::label('email', '* Correo', ['class'=>'col-form-label s-12']) !!}
										{!! Form::email('email', null, ['class'=>'form-control r-0 light s-12 ', 'id'=>'email', 'onclick'=>'inputClear(this.id)']) !!}
										<span class="email_span"></span>
									</div>
									<div class="form-group col-6 m-0">
										<i class="icon-phone mr-2"></i>
										{!! Form::label('phone1', 'Teléfono', ['class'=>'col-form-label s-12']) !!}
										{!! Form::text('phone1', null, ['class'=>'form-control r-0 light s-12', 'id'=>'phone1', 'onclick'=>'inputClear(this.id)']) !!}
									</div>
									<div class="form-group col-6 m-0" id="rol_group">
										{!! Form::label('rut', '* RUT', ['class'=>'col-form-label s-12']) !!}
										{!! Form::text('rut', null, ['class'=>'form-control r-0 light s-12', 'id'=>'rut', 'onclick'=>'inputClear(this.id)','required']) !!}
										<span class="rol_span"></span>
									</div>
									<div class="form-group col-6 m-0">
										{!! Form::label('position', 'Cargo', ['class'=>'col-form-label s-12']) !!}
										{!! Form::select('position', $positions, null, ['class'=>'form-control r-0 light s-12', 'id'=>'position', 'onclick'=>'inputClear(this.id)','required']) !!}
									</div>
									<div class="form-group col-6 m-0" id="rol_group">
										{!! Form::label('fecha_contrato', 'FECHA DE CONTRATO', ['class'=>'col-form-label s-12']) !!}
										{!! Form::date('fecha_contrato', null, ['class'=>'form-control r-0 light s-12', 'id'=>'fecha_contrato', 'onclick'=>'inputClear(this.id)']) !!}
										<span class="rol_span"></span>
									</div>
									<div class="form-group col-6 m-0" id="rol_group">
										{!! Form::label('fecha_fin_contrato', 'FECHA FIN DE CONTRATO', ['class'=>'col-form-label s-12']) !!}
										{!! Form::date('fecha_fin_contrato', null, ['class'=>'form-control r-0 light s-12', 'id'=>'fecha_fin_contrato', 'onclick'=>'inputClear(this.id)']) !!}
										<span class="rol_span"></span>
									</div>
								</div>
							</div>
							<div class="col-4">
								<div class="col-md-12 offset-md-1">
									<div class="form-group">
										<input id="file" class="file" name="file" type="file"  onchange="ValidarTamaño(this);" size="15">
									</div>
								</div>
							</div>
							
						</div>
						
						
						<div class="form-row">
							
							<div class="form-group col-4 m-0" id="rol_group">
								{!! Form::label('role', '* Perfil', ['class'=>'col-form-label s-12']) !!}
								{!! Form::select('rol', $roles, null, ['class'=>'form-control r-0 light s-12', 'id'=>'rol', 'onclick'=>'inputClear(this.id)','required']) !!}
								<span class="rol_span"></span>
							</div>
							<div class="form-group col-4 m-0" id="status_group">
								{!! Form::label('status', 'Estado', ['class'=>'col-form-label s-12']) !!}
								{!! Form::select('status', $status, 1, ['class'=>'form-control r-0 light s-12', 'id'=>'status', 'onclick'=>'inputClear(this.id)']) !!}
								<span class="status_span"></span>
							</div>
							<div class="form-group col-4 m-0" id="status_group">
								{!! Form::label('grupo', 'Grupo', ['class'=>'col-form-label s-12']) !!}
								{!! Form::select('id_grupo', $grupos, null, ['class'=>'form-control r-0 light s-12', 'id'=>'id_grupo', 'onclick'=>'inputClear(this.id)','required']) !!}
								<span class="status_span"></span>
							</div>
							<div class="form-group col-12 m-0">
								{!! Form::label('address', 'Dirección', ['class'=>'col-form-label s-12']) !!}
								{!! Form::textarea('address', null, ['class'=>'form-control r-0 light s-12', 'id'=>'address', 'onclick'=>'inputClear(this.id)','rows'=>'2']) !!}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" id="save" class="btn btn-primary" onclick=""><i class="icon-save mr-2"></i>Guardar Datos</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">


	var _validFileExtensions = [".jpg",".png"];   
	function ValidarTamaño(obj)
	{
		
		if (obj.type == "file") {
        var sFileName = obj.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                    $('.file_span').html("");
                }

            }


             
            if (!blnValid) {
               /* alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));*/
              	$('.file_span').html("");
			  	$('.file_span').append("<p class='alert alert-danger'>Sorry,"+ sFileName + " is invalid, allowed extensions are: jpg</p>");
                obj.value = "";
                return false;
            }

            var fileSize = $('#file')[0].files[0].size;
		    var siezekiloByte = parseInt(fileSize / 1024);
		    if (siezekiloByte >  $('#file').attr('size')) {
		    	$('.file_span').html("");
		        $('.file_span').append("<p class='alert alert-danger'>Sorry,"+ sFileName + " size should not be greater than 15kb</p>");
                 $('.file').html("");
		        return false;
		    }
        }
    }
    return true;
	}
	$(document).ready(function() {
		$("#_password_confirmation").on("change", function( event ) {
		 var password = $("#_password").val();
		 var confirmation = $("#_password_confirmation").val();
		 console.log(password +"-"+confirmation);
		 if( password != confirmation){
		 	toastr.error('No coinciden con la contraseña ingresada');
		 	$("#save").attr('disabled',true);
		 }else{
		 	$("#save").attr('disabled',false);
		 }
		});

		
	$('#status').on('change',function(e){
		let select = this.value;

		if(select == 4){
			$('#div_dias').show();
		}else{
			$('#div_dias').hide();
		}
	})


	});
	
	function soloNumeros(e){
		var key = window.Event ? e.which : e.keyCode
		return (key >= 48 && key <= 57)
  	}
	
	
	function checkSubmit() {
		$("#loader-icon").fadeIn(3000);
		$('#create').modal('hide');
        $("#save").prop("disabled",true);
    }

</script>
{!! Form::close() !!}