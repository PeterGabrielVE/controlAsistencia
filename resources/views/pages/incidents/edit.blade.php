<!-- Modal -->
{!! Form::open(['method'=>'PUT','class'=>'formlDinamic form','id'=>'DataUpdate']) !!}
<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class="icon-eye"></i> Editar Modulo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-4 m-0">
								{!! Form::label('lbl_date', 'Fecha', ['class'=>'col-form-label s-12']) !!}
								{!! Form::date('date', null, ['class'=>'form-control r-0 light s-12',  'id'=>'_date']) !!}
							</div>
							<div class="form-group col-12 m-0">
								{!! Form::label('lbl_comment', 'Comentarios', ['class'=>'col-form-label s-12']) !!}
								{!! Form::textarea('comments', null, ['class'=>'form-control r-0 light s-12',  'id'=>'_comments', 'rows'=>'2']) !!}

								
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