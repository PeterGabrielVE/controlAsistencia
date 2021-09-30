<!-- Modal -->
{!! Form::open(['route'=>['asistencia.store',Auth::user()->id],'method'=>'POST','onsubmit'=>'loading()']) !!}
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"><i class="icon icon-documents3 text-blue s-18"></i>Marcar</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="form-row">
                    <div class="col-12">
                        <div class="col-12">
                            <video id="webcam" autoplay playsinline width="300" height="300"></video>
                            <canvas id="canvas" width="250" height="250"></canvas>
                        </div>
                        <div class="col-6"></div>
                    </div>
				</div>
                @if(isset($asistencia))
                    @if($asistencia->tipo == 0)
                        <input type="hidden" value="1" name="tipo">

                    @else
                        <input type="hidden" value="0" name="tipo">

                     @endif
                @else
                        <input type="hidden" value="0" name="tipo">

                @endif
                <input type="hidden" value="0" name="longitude" id="lngval">
                <input type="hidden" value="0" name="latitude" id="latval">
                <input type="hidden" name="image" class="image-tag">
                <input type="hidden"  name="note" id="nota">
                <a id="btnCamara" class="btn btn-success">Abrir Camara</a>
                <a id="btnOcultarCamara" class="btn btn-info" style="display:none;">Cerrar Camara</a>
                <a id="checker" class="btn btn-warning" style="display:none;">Tomar foto</a>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                @if(isset($asistencia))
                    @if($asistencia->tipo == 0)
                        <input type="hidden" value="1" name="tipo">
                        <button type="submit" class="btn btn-danger col-6 mw-100 btn_asistencia">Registrar Salida</button>
                    @else
                        <input type="hidden" value="0" name="tipo">
                        <button type="submit" class="btn btn-success col-6 mw-100 btn_asistencia">Registrar Entrada</button>
                     @endif
                @else
                        <input type="hidden" value="0" name="tipo">
                        <button type="submit" class="btn btn-success btn_asistencia">Registrar Entrada</button>
                @endif
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}
